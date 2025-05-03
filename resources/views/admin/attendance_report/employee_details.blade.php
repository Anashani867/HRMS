@extends('layouts.admin')

@section('title', 'تفاصيل الموظف')

@section('contentheader')
    تفاصيل الموظف
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">تفاصيل الحضور والغياب للموظف: {{ $employee->emp_name }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>تاريخ اليوم</th>
                        <th>الحالة</th>
                        <th>الراتب اليومي</th>
                        <th>الإضافات</th>
                        <th>الخصومات</th>
                        <th>الراتب النهائي</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalFinalSalary = 0;
                    @endphp
                    @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->day }}</td>
                            <td>{{ $attendance->status == 'present' ? 'حاضر' : 'غائب' }}</td>
                            <td>{{ $attendance->daily_wage }}</td>
                            <td>
                                @foreach ($attendance->additions as $add)
                                    {{ $add->value }} {{ $add->addition_type ? $add->addition_type->name : '-' }}<br>
                                @endforeach
                            </td>

                            <td>
                                @foreach ($attendance->deductions as $ded)
                                    {{ $ded->deduction_type ? $ded->deduction_type->name : '' }} - {{ $ded->value }}<br>
                                @endforeach
                            </td>

                            <td>{{ $attendance->final_salary }}</td>
                        </tr>
                        @php
                            $totalFinalSalary += $attendance->final_salary;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <div class="text-right">
                <strong>مجموع الراتب النهائي لجميع الأيام: {{ $totalFinalSalary }}</strong>
            </div>
        </div>
    </div>
@endsection
