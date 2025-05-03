@extends('layouts.admin')

@section('title', 'تقرير الحضور')

@section('contentheader')
    تقرير الحضور
@endsection

@section('contentheaderactivelink')
    <a href="{{ route('attendances.index') }}">قائمة الحضور</a>
@endsection

@section('contentheaderactive')
    عرض التقرير
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">تفاصيل الحضور والغياب</h3>
        </div>
        <div class="card-body">

            @if($open_period && $open_period->id == $period->id)
                <h4>الفترة: {{ $period->Month->name }} ({{ $period->START_DATE_M }} - {{ $period->END_DATE_M }})</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>اسم الموظف</th>
                            <th>عرض التفاصيل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances->groupBy('employee_id') as $employeeAttendances)
                            @php
                                $employee = $employeeAttendances->first()->employee;
                            @endphp
                            <tr>
                                <td>{{ $employee->emp_name }}</td>
                                <td>
                                    <a href="{{ route('attendance.employee.details', ['employee_id' => $employee->id, 'period_id' => $period->id]) }}" class="btn btn-primary">
                                        عرض التفاصيل
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            @else
                <div class="alert alert-warning text-center">
                    <strong>الفترة مغلقة!</strong> لا يمكن عرض التقرير لفترة غير مفتوحة.
                </div>
            @endif

        </div>
    </div>
@endsection
