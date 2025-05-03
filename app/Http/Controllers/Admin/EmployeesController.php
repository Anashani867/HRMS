<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Branche;
use App\Models\Departement;
use App\Models\jobs_categories;
use App\Models\Qualification;
use App\Models\Religion;
use App\Models\Countries;
use App\Models\Nationalitie;
use App\Models\governorates;
use App\Models\centers;
use App\Models\blood_groups;
use App\Models\Military_status;
use App\Models\driving_license_type;
use App\Models\Language;
use App\Models\Shifts_type;
use Illuminate\Support\Facades\Log;

class EmployeesController extends Controller
{
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_p(new Employee(), array("*"), array("com_code" => $com_code), "id", "DESC", PC);
        return view("admin.Employees.index", ['data' => $data]);
    }

    public function create()
    {
        $com_code = auth()->user()->com_code;
        $other['branches'] = get_cols_where(new Branche(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['departements'] = get_cols_where(new Departement(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['jobs'] = get_cols_where(new jobs_categories(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['qualifications'] = get_cols_where(new Qualification(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['religions'] = get_cols_where(new Religion(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['nationalities'] = get_cols_where(new Nationalitie(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['countires'] = get_cols_where(new Countries(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['blood_groups'] = get_cols_where(new blood_groups(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['military_status'] = get_cols_where(new Military_status(), array("id", "name"), array("active" => 1),'id','ASC');
        $other['driving_license_types'] = get_cols_where(new driving_license_type(), array("id", "name"), array("active" => 1,"com_code" => $com_code),'id','ASC');
        $other['shifts_types'] = get_cols_where(new Shifts_type(), array("id", "type","from_time","to_time","total_hour"), array("active" => 1,"com_code" => $com_code),'id','ASC');
        $other['languages'] = get_cols_where(new Language(), array("id", "name"), array("active" => 1,"com_code" => $com_code),'id','ASC');


        return view("admin.Employees.create", ['other' => $other]);
    }

    public function generateEmployeeCode()
    {
        // يمكن استخدام رقم تسلسلي أو أي منطق آخر لتوليد كود فريد
        $lastEmployee = Employee::latest('employees_code')->first();
        $newCode = $lastEmployee ? $lastEmployee->employees_code + 1 : 1; // إذا لم يوجد موظف، يبدأ من 1
        
        return $newCode;
    }

    public function store(Request $request)
{
    $com_code = auth()->user()->com_code;
    Log::info('Com Code: ' . $com_code);

    // try {
        // التحقق من صحة البيانات المدخلة
        $validated = $request->validate([
            'emp_name' => 'required|string|max:255',
            'emp_email' => 'required|email|unique:employees,emp_email',
            'emp_gender' => 'required|in:0,1',  // تحقق من وجود قيمة emp_gender
            'emp_sal' => 'required|numeric',  // تحقق من وجود قيمة راتب الموظف
            'emp_start_date' => 'required|date',  // تأكد من تاريخ بداية العمل
            'blood_group_id' => 'nullable|exists:blood_groups,id',  // الدم اختياري
            'emp_home_tel' => 'nullable|string|max:15',  // التحقق من رقم الهاتف المنزل
            'emp_work_tel' => 'nullable|string|max:15',  // التحقق من رقم الهاتف العمل
            'emp_military_id' => 'nullable|exists:military_status,id',  // حالة التجنيد
            'emp_military_date_from' => 'nullable|date',  // تاريخ بداية الخدمة العسكرية
            'emp_military_date_to' => 'nullable|date',  // تاريخ انتهاء الخدمة العسكرية
            'does_has_Driving_License' => 'required|in:0,1',  // تحقق من القيم المقبولة فقط 0 أو 1
            'driving_License_degree' => 'nullable|string|max:255',  // درجة رخصة القيادة
            'shift_type_id' => 'nullable|exists:shifts_types,id',  // نوع الشفت
            'religion_id' => 'nullable|exists:religions,id', 
            'daily_work_hour' => 'nullable|numeric',  // عدد ساعات العمل اليومية
            'Functiona_status' => 'nullable|in:0,1',  // حالة الوظيفة
            'is_active_for_Vaccation' => 'nullable|in:0,1',  // حالة التفعيل للإجازة
            'emp_pasport_no' => 'nullable|string|max:50',  // رقم الجواز
            'emp_pasport_from' => 'nullable|string|max:255',  // مصدر الجواز
            'emp_pasport_exp' => 'nullable|date',  // تاريخ انتهاء الجواز
            'emp_Basic_stay_com' => 'nullable|string|max:255',  // مكان الإقامة
            'emp_Departments_code' => 'required|exists:departements,id',
            'emp_jobs_id' => 'required|exists:jobs_categories,id',
            'branch_id' => 'required|exists:branches,id',
            'emp_Departments_code' => 'required|exists:departements,id',
            'emp_jobs_id' => 'required|exists:jobs_categories,id',
            'emp_nationality_id' => 'required|exists:nationalities,id',

        ]);

        // إعداد البيانات لإضافتها في قاعدة البيانات
        $data = $request->only([
            'employees_code',
            'zketo_code',
            'emp_name',
            'emp_gender',
            'branch_id',
            'Qualifications_id',
            'Qualifications_year',
            'graduation_estimate',
            'Graduation_specialization',
            'brith_date',
            'emp_national_idenity',
            'emp_end_identityIDate',
            'emp_identityPlace',
            'blood_group_id',
            'religion_id',
            'emp_lang_id',
            'emp_email',
            'country_id',
            'governorate_id',
            'city_id',
            'emp_home_tel',
            'emp_work_tel',
            'emp_military_id',
            'emp_military_date_from',
            'emp_military_date_to',
            'emp_military_wepon',
            'exemption_date',
            'exemption_reason',
            'postponement_reason',
            'Date_resignation',
            'resignation_cause',
            'does_has_Driving_License',
            'driving_License_degree',
            'driving_license_types_id',
            'Relatives_details',
            'notes',
            'emp_start_date',
            'Functiona_status',
            'emp_Departments_code',
            'emp_jobs_id',
            'is_has_fixced_shift',
            'shift_type_id',
            'daily_work_hour',
            'emp_sal',
            'Socialnsurancecutmonthely',
            'SocialnsuranceNumber',
            'medicalinsurancecutmonthely',
            'medicalinsuranceNumber',
            'is_active_for_Vaccation',
            'urgent_person_details',
            'staies_address',
            'Resignations_id',
            'Disabilities_processes',
            'emp_cafel',
            'emp_pasport_no',
            'emp_pasport_from',
            'emp_pasport_exp',
            'emp_photo',
            'emp_CV',
            'emp_Basic_stay_com',
            'date',
            'day_price',
            'added_by',
            'com_code' ,
            'emp_nationality_id',




        ]);
        
        if (empty($data['shifts_types_id'])) {
            $data['shift_type_id'] = null; // أو يمكنك تحديد قيمة افتراضية
        }
        

        // تحديد employees_code يدويًا
        $data['employees_code'] = $this->generateEmployeeCode(); // استدعاء دالة لتوليد كود الموظف
        $data['com_code'] = $com_code;
        $data['added_by'] = auth()->user()->id;

        // حفظ الموظف في قاعدة البيانات
        $employee = Employee::create($data);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route("Employees.index")->with('success', 'تم إضافة الموظف بنجاح');
    // } catch (\Exception $e) {
    //     Log::error('Error while storing employee: ' . $e->getMessage(), [
    //         'data' => $request->all(),
    //     ]);

        // return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة الموظف');
    // }
}


public function edit($id)
{
    $com_code = auth()->user()->com_code;
    $info = Employee::where('id', $id)->where('com_code', $com_code)->firstOrFail();

    $other['branches'] = get_cols_where(new Branche(), ["id", "name"], ["com_code" => $com_code, "active" => 1]);
    $other['departements'] = get_cols_where(new Departement(), ["id", "name"], ["com_code" => $com_code, "active" => 1]);
    $other['jobs'] = get_cols_where(new jobs_categories(), ["id", "name"], ["com_code" => $com_code, "active" => 1]);
    $other['qualifications'] = get_cols_where(new Qualification(), ["id", "name"], ["com_code" => $com_code, "active" => 1]);
    $other['religions'] = get_cols_where(new Religion(), ["id", "name"], ["com_code" => $com_code, "active" => 1]);
    $other['nationalities'] = get_cols_where(new Nationalitie(), ["id", "name"], ["com_code" => $com_code, "active" => 1]);
    $other['countires'] = get_cols_where(new Countries(), ["id", "name"], ["com_code" => $com_code, "active" => 1]);
    $other['blood_groups'] = get_cols_where(new blood_groups(), ["id", "name"], ["com_code" => $com_code, "active" => 1]);
    $other['military_status'] = get_cols_where(new Military_status(), ["id", "name"], ["active" => 1], 'id', 'ASC');
    $other['driving_license_types'] = get_cols_where(new driving_license_type(), ["id", "name"], ["active" => 1, "com_code" => $com_code], 'id', 'ASC');
    $other['shifts_types'] = get_cols_where(new Shifts_type(), ["id", "type", "from_time", "to_time", "total_hour"], ["active" => 1, "com_code" => $com_code], 'id', 'ASC');
    $other['languages'] = get_cols_where(new Language(), ["id", "name"], ["active" => 1, "com_code" => $com_code], 'id', 'ASC');

    return view("admin.Employees.edit", compact("info", "other"));
}

   

public function update(Request $request, $id)
{
    $com_code = auth()->user()->com_code;
    $employee = Employee::where('id', $id)->where('com_code', $com_code)->firstOrFail();

    $validated = $request->validate([
        'emp_name' => 'required|string|max:255',
        'emp_email' => 'required|email|unique:employees,emp_email',
        'emp_gender' => 'required|in:0,1',  // تحقق من وجود قيمة emp_gender
        'emp_sal' => 'required|numeric',  // تحقق من وجود قيمة راتب الموظف
        'emp_start_date' => 'required|date',  // تأكد من تاريخ بداية العمل
        'blood_group_id' => 'nullable|exists:blood_groups,id',  // الدم اختياري
        'emp_home_tel' => 'nullable|string|max:15',  // التحقق من رقم الهاتف المنزل
        'emp_work_tel' => 'nullable|string|max:15',  // التحقق من رقم الهاتف العمل
        'emp_military_id' => 'nullable|exists:military_status,id',  // حالة التجنيد
        'emp_military_date_from' => 'nullable|date',  // تاريخ بداية الخدمة العسكرية
        'emp_military_date_to' => 'nullable|date',  // تاريخ انتهاء الخدمة العسكرية
        'does_has_Driving_License' => 'required|in:0,1',  // تحقق من القيم المقبولة فقط 0 أو 1
        'driving_License_degree' => 'nullable|string|max:255',  // درجة رخصة القيادة
        'shift_type_id' => 'nullable|exists:shifts_types,id',  // نوع الشفت
        'religion_id' => 'nullable|exists:religions,id', 
        'daily_work_hour' => 'nullable|numeric',  // عدد ساعات العمل اليومية
        'Functiona_status' => 'nullable|in:0,1',  // حالة الوظيفة
        'is_active_for_Vaccation' => 'nullable|in:0,1',  // حالة التفعيل للإجازة
        'emp_pasport_no' => 'nullable|string|max:50',  // رقم الجواز
        'emp_pasport_from' => 'nullable|string|max:255',  // مصدر الجواز
        'emp_pasport_exp' => 'nullable|date',  // تاريخ انتهاء الجواز
        'emp_Basic_stay_com' => 'nullable|string|max:255',  // مكان الإقامة
        'emp_Departments_code' => 'required|exists:departements,id',
        'emp_jobs_id' => 'required|exists:jobs_categories,id',
        'branch_id' => 'required|exists:branches,id',
        'emp_Departments_code' => 'required|exists:departements,id',
        'emp_jobs_id' => 'required|exists:jobs_categories,id',
        'emp_nationality_id' => 'required|exists:nationalities,id',

    ]);

    // إعداد البيانات لإضافتها في قاعدة البيانات
    $data = $request->only([
        'employees_code',
        'zketo_code',
        'emp_name',
        'emp_gender',
        'branch_id',
        'has_Relatives',
        'Qualifications_id',
        'Qualifications_year',
        'graduation_estimate',
        'Graduation_specialization',
        'brith_date',
        'emp_national_idenity',
        'emp_end_identityIDate',
        'emp_identityPlace',
        'blood_group_id',
        'religion_id',
        'emp_lang_id',
        'emp_email',
        'country_id',
        'governorate_id',
        'city_id',
        'emp_home_tel',
        'emp_work_tel',
        'emp_military_id',
        'emp_military_date_from',
        'emp_military_date_to',
        'emp_military_wepon',
        'exemption_date',
        'exemption_reason',
        'postponement_reason',
        'Date_resignation',
        'resignation_cause',
        'does_has_Driving_License',
        'driving_License_degree',
        'driving_license_types_id',
        'Relatives_details',
        'notes',
        'emp_start_date',
        'Functiona_status',
        'emp_Departments_code',
        'emp_jobs_id',
        'is_has_fixced_shift',
        'shift_type_id',
        'daily_work_hour',
        'emp_sal',
        'Socialnsurancecutmonthely',
        'SocialnsuranceNumber',
        'medicalinsurancecutmonthely',
        'medicalinsuranceNumber',
        'is_active_for_Vaccation',
        'urgent_person_details',
        'staies_address',
        'Resignations_id',
        'Disabilities_processes',
        'emp_cafel',
        'emp_pasport_no',
        'emp_pasport_from',
        'emp_pasport_exp',
        'emp_photo',
        'emp_CV',
        'emp_Basic_stay_com',
        'date',
        'day_price',
        'added_by',
        'com_code' ,
        'emp_nationality_id',

    ]);

    $data['updated_by'] = auth()->user()->id;

    $employee->update($data);

    return redirect()->route("Employees.index", $id)->with('success', 'تم تعديل بيانات الموظف بنجاح');
}

public function destroy($id)
{
    $employee = Employee::findOrFail($id);
    $employee->delete();

    return redirect()->route('Employees.index')->with('success', 'تم حذف الموظف بنجاح');
}

    

    public function get_governorates(Request $request)
    {
        if ($request->ajax()) {
            $country_id = $request->country_id;
            $other['governorates'] = get_cols_where(new governorates(), array("id", "name"), array("com_code" => auth()->user()->com_code, 'countires_id' => $country_id));
            return view('admin.Employees.get_governorates',['other'=>$other]);
        }
    }

    public function get_centers(Request $request)
    {
        if ($request->ajax()) {
            $governorates_id = $request->governorates_id;
            $other['centers'] = get_cols_where(new centers(), array("id", "name"), array("com_code" => auth()->user()->com_code, 'governorates_id' => $governorates_id));
            return view('admin.Employees.get_centers',['other'=>$other]);
        }
    }



}
