<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\DiscountsType;
use App\Models\EmployeeSalaryDeduction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // إضافة Carbon لتحويل التاريخ

class EmployeeSalaryDeductionController extends Controller
{
    public function create()
    {
        $com_code = auth()->user()->com_code;
        $employees = Employee::where('com_code', $com_code)->get();
        $DiscountsType = DiscountsType::where('com_code', $com_code)->where('active', 1)->get();

        return view('admin.employee_salary_deduction.create', compact('employees', 'DiscountsType'));
    }


    public function store(Request $request)
{
    try {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'discounts_types_id' => 'required|exists:discounts_types,id',
            'value' => 'required|numeric|min:0.01',
            'date' => 'required|date',
        ]);

        DB::beginTransaction();

        $date = Carbon::parse($request->date)->format('Y-m-d');

        // إنشاء سجل الخصم
        $salaryDeduction = EmployeeSalaryDeduction::create([
            'employee_id' => $request->employee_id,
            'discounts_types_id' => $request->discounts_types_id,
            'value' => $request->value,
            'date' => $date,
            'notes' => $request->notes,
            'added_by' => auth()->user()->id,
            'com_code' => auth()->user()->com_code,
        ]);

        $mainSalaryRecord = \App\Models\MainSalaryRecord::where('is_open', 1)
            ->where('com_code', auth()->user()->com_code)
            ->latest()
            ->first();

        if (!$mainSalaryRecord) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'لا يوجد سجل راتب مفتوح حالياً.'])->withInput();
        }

        $total_discounts = $salaryDeduction->value;

        $employeeSalaryRecord = \App\Models\EmployeeSalaryRecord::where('main_salary_record_id', $mainSalaryRecord->id)
            ->where('employee_id', $request->employee_id)
            ->first();

        if ($employeeSalaryRecord) {
            $employeeSalaryRecord->total_deductions += $total_discounts;
        } else {
            $employeeSalaryRecord = new \App\Models\EmployeeSalaryRecord([
                'main_salary_record_id' => $mainSalaryRecord->id,
                'employee_id' => $request->employee_id,
                'com_code' => auth()->user()->com_code,
                'date' => $date,
                'added_by' => auth()->user()->id,
                'total_additions' => 0,
                'total_deductions' => $total_discounts,
                'final_salary' => 0,
            ]);
        }

        $employeeSalaryRecord->save();

        DB::commit();
        return redirect()->back()->with(['success' => 'تمت إضافة الخصم للموظف بنجاح']);
    } catch (\Exception $ex) {
        DB::rollBack();
        return redirect()->back()->with(['error' => 'حدث خطأ: ' . $ex->getMessage()])->withInput();
    }
}


    

}
