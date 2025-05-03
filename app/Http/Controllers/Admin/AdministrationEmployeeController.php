<?php

namespace App\Http\Controllers\Admin;
use App\Models\AdministrationEmployee;
use App\Models\Employee;
use App\Models\Departement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\Http\Requests\DiscountsTypesRequest;

class AdministrationEmployeeController extends Controller
{
//     public function index()
//     {
//         $administrationEmployees = AdministrationEmployee::with(['employee', 'department'])->get();
    
//         return view('admin.administration_employees.index', compact('administrationEmployees'));
//     }

//     public function create()
// {
//     $employees = Employee::all();  // جلب جميع الموظفين
//     $departments = Departement::all();  // جلب جميع الأقسام

//     return view('admin.administration_employees.create', compact('employees', 'departments'));
// }

// public function store(Request $request)
// {
//     // التحقق من البيانات (validation)
//     $validated = $request->validate([
//         'employee_id' => 'required|exists:employees,id',
//         'department_id' => 'required|exists:departements,id',
//         'assigned_at' => 'nullable|date',
//     ]);

//     // الحفظ في قاعدة البيانات
//     \App\Models\AdministrationEmployee::create($validated);

//     // الرجوع مع رسالة نجاح
//     return redirect()->route('administration_employees.index')->with('success', 'تمت الإضافة بنجاح');
// }

public function index()
{
    $com_code = auth()->user()->com_code;

    $data = AdministrationEmployee::with(['employee', 'department']) // عشان تجيب القسم كمان
        ->where('com_code', $com_code)
        ->get();

    return view('admin.administration_employees.index', ['data' => $data]);
}


public function create()
{
    $com_code = auth()->user()->com_code;
    $employees = Employee::all();  
    $departments = Departement::all();
    return view('admin.administration_employees.create', compact('employees', 'departments'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'department_id' => 'required|exists:departements,id',
        'assigned_at' => 'nullable|date',
    ]);

    try {
        $com_code = auth()->user()->com_code;

        $CheckExsists = AdministrationEmployee::where([
            "com_code" => $com_code,
            "employee_id" => $request->employee_id,
            "department_id" => $request->department_id,
        ])->first();

        if ($CheckExsists) {
            return redirect()->back()->with(['error' => 'عفوا هذا الموظف مسجل بالفعل في هذا القسم'])->withInput();
        }

        DB::beginTransaction();

        $DataToInsert = [
            'employee_id' => $request->employee_id,
            'department_id' => $request->department_id,
            'assigned_at' => $request->assigned_at,
            'added_by' => auth()->user()->id,
            'com_code' => $com_code,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        AdministrationEmployee::insert($DataToInsert);

        DB::commit();
        return redirect()->route('administration_employees.index')->with(['success' => 'تم تسجيل البيانات بنجاح']);
    } catch (\Exception $ex) {
        DB::rollBack();
        return redirect()->back()->with(['error' => 'عفوا  حدث خطأ: ' . $ex->getMessage()])->withInput();
    }
}




public function edit($id)
{
    $com_code = auth()->user()->com_code;

    $adminEmployee = AdministrationEmployee::with(['employee', 'department'])
        ->where('id', $id)
        ->where('com_code', $com_code)

        ->first();

    if (!$adminEmployee) {
        return redirect()->route('administration_employees.index')->with(['error' => 'عفوا غير قادر للوصول الي البيانات المطلوبة']);
    }

    // جيب كل الموظفين
    $employees = Employee::where('com_code', $com_code)->get();

    // جيب كل الأقسام
    $departments = Departement::where('com_code', $com_code)->get();

    return view('admin.administration_employees.edit', [
        'data' => $adminEmployee,
        'employees' => $employees,
        'departments' => $departments,
    ]);
}



public function update($id, Request $request)
{
    try {
        $com_code = auth()->user()->com_code;

        // تحقق من أن السجل موجود
        $data = AdministrationEmployee::where('id', $id)
            ->where('com_code', $com_code)
            ->first();

        if (!$data) {
            return redirect()->route('administration_employees.index')
                ->with(['error' => 'عفوا غير قادر للوصول إلى البيانات المطلوبة']);
        }

        // تحقق من عدم وجود سجل آخر بنفس الموظف ونفس القسم
        $CheckExsists = AdministrationEmployee::where('com_code', $com_code)
            ->where('employee_id', $request->employee_id)
            ->where('department_id', $request->department_id)
            ->where('id', '!=', $id)
            ->first();

        if ($CheckExsists) {
            return redirect()->back()
                ->with(['error' => 'عفوا هذا الموظف مسجل بالفعل في هذا القسم'])
                ->withInput();
        }

        DB::beginTransaction();

        // تحديث البيانات
        $data->update([
            'employee_id' => $request->employee_id,
            'department_id' => $request->department_id, // ✅ إضافتها هنا
            'active' => $request->active,
            'updated_by' => auth()->user()->id,
        ]);

        DB::commit();

        return redirect()->route('administration_employees.index')
            ->with(['success' => 'تم تحديث البيانات بنجاح']);
    } catch (\Exception $ex) {
        DB::rollBack();
        return redirect()->back()
            ->with(['error' => 'عفوا حدث خطأ: ' . $ex->getMessage()])
            ->withInput();
    }
}


public function destroy($id)
{
    try {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row(new AdministrationEmployee(), array("*"), array("com_code" => $com_code, 'id' => $id));
        if (empty($data)) {
            return redirect()->route('administration_employees.index')->with(['error' => 'عفوا غير قادر للوصول الي البيانات المطلوبة']);
        }
        DB::beginTransaction();
        destroy(new AdministrationEmployee(), array("com_code" => $com_code, 'id' => $id));
        DB::commit();
        return redirect()->route('administration_employees.index')->with(['success' => 'تم الحذف  البيانات بنجاح']);
    } catch (\Exception $ex) {
        DB::rollBack();
        return redirect()->back()->with(['error' => 'عفوا حدث خطأ  ' . $ex->getMessage()])->withInput();
    }
}
    }
