<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\AdtionalTypes;
use App\Models\EmployeeSalaryAddition;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeSalaryAdditionController extends Controller
{
    public function create()
    {
        $com_code = auth()->user()->com_code;
        $employees = Employee::where('com_code', $com_code)->get();
        $adtionalTypes = AdtionalTypes::where('com_code', $com_code)->where('active', 1)->get();

        return view('admin.employee_salary_addition.create', compact('employees', 'adtionalTypes'));
    }


    public function store(Request $request)
{
    try {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'adtional_type_id' => 'required|exists:additional_types,id',
            'value' => 'required|numeric|min:0.01',
            'date' => 'required|date',
        ]);
    
        DB::beginTransaction();
    
        // تحويل التاريخ باستخدام Carbon لضمان الصيغة الصحيحة
        $date = Carbon::parse($request->date)->format('Y-m-d');
    
        // إنشاء سجل الإضافي
        $salaryAddition = EmployeeSalaryAddition::create([
            'employee_id' => $request->employee_id,
            'adtional_type_id' => $request->adtional_type_id,
            'value' => $request->value,
            'date' => $date,
            'notes' => $request->notes,
            'added_by' => auth()->user()->id,
            'com_code' => auth()->user()->com_code,
        ]);
    
        // جلب سجل الرواتب المفتوح
        $mainSalaryRecord = \App\Models\MainSalaryRecord::where('is_open', 1)
            ->where('com_code', auth()->user()->com_code)
            ->latest()
            ->first();
    
        if (!$mainSalaryRecord) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'لا يوجد سجل راتب مفتوح حالياً.'])->withInput();
        }
    
        // حساب الإضافة فقط (نستخدم قيمة الزيادة فقط)
        $total_additions = $salaryAddition->value;  // فقط الزيادة المدخلة

        // جلب السجل الحالي إذا كان موجودًا لتحديثه
        $employeeSalaryRecord = \App\Models\EmployeeSalaryRecord::where('main_salary_record_id', $mainSalaryRecord->id)
            ->where('employee_id', $request->employee_id)
            ->first();

        // إذا كان السجل موجودًا بالفعل، نضيف الزيادة إلى القيمة الحالية
        if ($employeeSalaryRecord) {
            $employeeSalaryRecord->total_additions += $total_additions; // إضافة الزيادة إلى القيمة الحالية
            $employeeSalaryRecord->date = $date; // تحديث التاريخ
        } else {
            $employeeSalaryRecord = new \App\Models\EmployeeSalaryRecord([
                'main_salary_record_id' => $mainSalaryRecord->id,
                'employee_id' => $request->employee_id,
                'com_code' => auth()->user()->com_code,
                'date' => $date,
                'added_by' => auth()->user()->id,
                'total_additions' => $total_additions,
                'total_deductions' => 0,
                'final_salary' => 0,
            ]);
        }
    
        $employeeSalaryRecord->save();
    
        DB::commit();
        return redirect()->back()->with(['success' => 'تمت إضافة الإضافي للموظف بنجاح']);
    } catch (\Exception $ex) {
        DB::rollBack();
        return redirect()->back()->with(['error' => 'حدث خطأ: ' . $ex->getMessage()])->withInput();
    }
}

    

}
