<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\MainSalaryRecord;
use App\Models\Finance_cln_periods;
use App\Models\EmployeeSalaryAddition;
use App\Models\EmployeeSalaryDeduction;
use App\Models\AdtionalTypes;
use App\Models\DiscountsType;
use Illuminate\Http\Request;

class AttendanceReportController extends Controller
{

    public function index(Request $request, $period_id = null)
    {
        $com_code = auth()->user()->com_code;
    
        // إذا لم يتم تمرير period_id، جلب الفترة المفتوحة تلقائيًا
        if (!$period_id) {
            $open_period = \App\Models\Finance_cln_periods::where('is_open', 1)
                ->where('com_code', $com_code)
                ->latest()
                ->first();
    
            if (!$open_period) {
                return view('admin.attendance_report.index', [
                    'attendances' => collect(),
                    'open_period' => null,
                    'period' => null,
                ]);
            }
    
            $period_id = $open_period->id;
        }
    
        // استرجاع الفترة بناءً على period_id
        $open_period = \App\Models\Finance_cln_periods::where('id', $period_id)
            ->where('com_code', $com_code)
            ->first();
    
        if (!$open_period) {
            return view('admin.attendance_report.index', [
                'attendances' => collect(),
                'open_period' => null,
                'period' => null,
            ]);
        }
    
        // استرجاع بيانات الحضور المرتبطة بالفترة المفتوحة
        $attendances = Attendance::where('period_id', $open_period->id)
            ->where('com_code', $com_code)
            ->get();
    
        return view('admin.attendance_report.index', [
            'attendances' => $attendances,
            'open_period' => $open_period,
            'period' => $open_period,
        ]);
    }
    public function showEmployeeDetails($employee_id, $period_id)
    {
        $com_code = auth()->user()->com_code;
    
        // استرجاع بيانات الموظف
        $employee = Employee::findOrFail($employee_id);
    
        // استرجاع بيانات الحضور المرتبطة بالفترة والموظف
        $attendances = Attendance::where('employee_id', $employee_id)
            ->where('period_id', $period_id)
            ->where('com_code', $com_code)
            ->get();
    
        // حساب الإضافات والخصومات لكل يوم
        $attendanceWithDetails = $attendances->map(function ($attendance) use ($employee) {
            // نحسب الراتب اليومي بناءً على الراتب الشهري وعدد أيام الشهر
            $working_days_in_month = 30; // أو حسب الشهر الحالي إذا أردت
            $daily_wage = $employee && $employee->emp_sal ? round($employee->emp_sal / $working_days_in_month, 2) : 0;
        
            $attendance->daily_wage = $daily_wage;
            $attendance->salary = $attendance->status == 'present' ? $daily_wage : 0;
        
            // استرجاع الإضافات والخصومات لكل يوم
            $employeeAdditions = EmployeeSalaryAddition::with('addition_type')
            ->where('employee_id', $attendance->employee_id)
            ->whereDate('date', $attendance->day)
            ->orderBy('value', 'desc')
            ->get();
        
        $employeeDeductions = EmployeeSalaryDeduction::with('deduction_type')
            ->where('employee_id', $attendance->employee_id)
            ->whereDate('date', $attendance->day)
            ->orderBy('value', 'desc')
            ->get();
        
            // مجموع الإضافات والخصومات
        $attendance->additions = $employeeAdditions;
        $attendance->deductions = $employeeDeductions;
        // dd($employeeAdditions);

        
        // حساب المجموع من القيم
        $total_additions = $employeeAdditions->sum('value');
        $total_deductions = $employeeDeductions->sum('value');
        
        $attendance->daily_wage = $daily_wage;
        $attendance->salary = $attendance->status == 'present' ? $daily_wage : 0;
        $attendance->final_salary = $attendance->status == 'present' ? $attendance->salary + $total_additions - $total_deductions : 0;
                
            return $attendance;
        });
    
        return view('admin.attendance_report.employee_details', [
            'employee' => $employee,
            'attendances' => $attendanceWithDetails,
        ]);
    }
    
}
