<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainSalaryRecord;
use App\Models\Admin;
use App\Models\Finance_calendar;
use App\Models\Finance_cln_periods;
use App\Models\Employee;


class MainSalaryRecordController extends Controller
{
    public function index()
{
    $com_code = auth()->user()->com_code;

    $data = get_cols_where_p(new Finance_cln_periods(), array("*"), array("com_code" => $com_code), 'id', 'DESC', 12);

    // $data = Finance_cln_periods::join('finance_calenders as c', 'finance_cln_periods.finance_calenders_id', '=', 'c.id')
    // ->where('c.is_open', 1) // السنة المالية المفتوحة
    // ->orderBy('finance_cln_periods.year_and_month', 'ASC') // ترتيب حسب year_and_month
    // ->paginate(12);

    // جيب الفترة المفتوحة
    $open_period = Finance_cln_periods::where('com_code', $com_code)
        ->whereHas('mainSalaryRecord', function ($query) {
            $query->where('is_open', 1);
        })->latest()->first();

    // جيب الموظفين
    $employees = Employee::where('com_code', $com_code)->get();

    return view('admin.MainSalaryRecord.index', compact('data', 'open_period', 'employees'));
}


    public function openRecord($id)
{
    $com_code = auth()->user()->com_code;

    // تحقق هل يوجد سجل بالفعل مفتوح لهذا الشهر؟
    $exists = MainSalaryRecord::where('period_id', $id)
        ->where('com_code', $com_code)
        ->where('is_open', 1)
        ->first();

    if ($exists) {
        return redirect()->back()->with(['error' => 'تم فتح سجل لهذا الشهر مسبقًا']);
    }

    // إنشاء سجل جديد
    MainSalaryRecord::create([
        'period_id' => $id,
        'com_code' => $com_code,
        'is_open' => 1,
        'added_by' => auth()->user()->id,
        'opened_at' => now(),
        'created_by' => auth()->id(),
    ]);

    return redirect()->back()->with(['success' => 'تم فتح سجل الرواتب بنجاح']);
}

public function open($period_id)
{
    $com_code = auth()->user()->com_code;

    // تأكد أنه ما تم فتحه مسبقًا
    $check = MainSalaryRecord::where('com_code', $com_code)->where('period_id', $period_id)->first();
    if ($check) {
        return redirect()->back()->with(['error' => 'تم فتح هذا السجل مسبقًا!']);
    }

    // إضافة سجل جديد
    MainSalaryRecord::create([
        'period_id' => $period_id,
        'com_code' => $com_code,
        'is_open' => 1,
        'opened_at' => now(),
        'added_by' => auth()->user()->id,
    ]);

    return redirect()->back()->with(['success' => 'تم فتح سجل الرواتب بنجاح']);
}

public function close($period_id)
{
    $com_code = auth()->user()->com_code;

    $record = MainSalaryRecord::where('period_id', $period_id)
                ->where('com_code', $com_code)
                ->first();

    if (!$record) {
        return redirect()->back()->with(['error' => 'السجل غير موجود!']);
    }

    if ($record->is_open == 0) {
        return redirect()->back()->with(['error' => 'السجل مغلق مسبقًا!']);
    }

    $record->update([
        'is_open' => 0, 
        'updated_by' => auth()->user()->id,
        'updated_at' => now(),
    ]);

    return redirect()->back()->with(['success' => 'تم إغلاق سجل الرواتب بنجاح']);
}

public function store(Request $request)
{
    $period_id = $request->period_id;
    $data = $request->attendance;

    foreach ($data as $employee_id => $info) {
        Attendance::updateOrCreate([
            'employee_id' => $employee_id,
            'period_id' => $period_id,
            'day' => $info['day'],
        ], [
            'status' => $info['status']
        ]);
    }

    return redirect()->back()->with('success', 'تم حفظ الحضور بنجاح!');
}



    
//     public function create()
//    {
//    return view('admin.MainSalaryRecord.create');
//      }


}
