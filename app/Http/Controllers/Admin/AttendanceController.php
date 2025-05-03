<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Finance_cln_periods; // تأكد من إضافة موديل الفترة المالية
use App\Models\Employee; // تأكد من إضافة موديل الموظف
use App\Models\MainSalaryRecord; // تأكد من إضافة موديل الموظف

class AttendanceController extends Controller
{
    public function index()
    {
        $com_code = auth()->user()->com_code;

        // جلب الفترة المفتوحة
        $open_period = Finance_cln_periods::where('com_code', $com_code)
        ->whereHas('mainSalaryRecord', function ($query) {
            $query->where('is_open', 1);
        })->latest()->first();
        // جلب جميع الموظفين
        $employees = Employee::where('com_code', auth()->user()->com_code)->get();

        // جلب سجلات الحضور المرتبطة بالفترة المفتوحة
        $attendances = Attendance::where('period_id', $open_period ? $open_period->id : null)
            ->where('com_code', auth()->user()->com_code)
            ->get();

        return view('admin.attendances.index', compact('attendances', 'employees', 'open_period'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'attendance.*.day' => 'required|date',
            'attendance.*.status' => 'required|in:present,absent',
        ]);
    
        // الحصول على period_id و company_code
        $period_id = $request->period_id;
        $company_code = auth()->user()->com_code;
    
        // جلب الفترة المفتوحة
        $period = \App\Models\Finance_cln_periods::find($period_id);
    
        if (!$period) {
            return redirect()->back()->with('error', 'الفترة غير موجودة');
        }
    
        // تجهيز البيانات
        $attendanceRecords = [];
    
        foreach ($request->attendance as $employee_id => $data) {
            $day = $data['day'];
    
            // التحقق إن التاريخ ضمن الفترة
            if ($day < $period->START_DATE_M || $day > $period->END_DATE_M) {
                return redirect()->back()->with('error', 'تاريخ ' . $day . ' خارج نطاق الفترة المفتوحة.');
            }
    
            $attendanceRecords[] = [
                'employee_id' => $employee_id,
                'period_id' => $period_id,
                'day' => $day,
                'status' => $data['status'],
                'com_code' => $company_code,
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        // إدخال البيانات دفعة واحدة
        Attendance::insert($attendanceRecords);
    
        return redirect()->back()->with('success', 'تم حفظ الحضور بنجاح');
    }
    
}
