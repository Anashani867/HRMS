@extends('layouts.admin')

@section('title')
    سجلات الحضور
@endsection

@section('contentheader')
    قائمة الحضور
@endsection

@section('contentheaderactivelink')
    <a href="{{ route('attendances.index') }}">السجلات</a>
@endsection

@section('contentheaderactive')
    عرض
@endsection

@section('content')
<div class="col-12">
   <div class="card">
      <div class="card-header">
         <h3 class="card-title card_title_center">بيانات الحضور للمرة المفتوحة</h3>
      </div>
      <div class="card-body">
         @if($open_period)
@if($open_period)
    <h4>الفترة المفتوحة: {{ $open_period->Month->name }} ({{ $open_period->START_DATE_M }} - {{ $open_period->END_DATE_M }})</h4>
@else
    <div class="alert alert-warning">لا توجد فترة مفتوحة حاليًا</div>
@endif
            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf
                <input type="hidden" name="period_id" value="{{ $open_period->id }}">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>اسم الموظف</th>
                            <th>تاريخ اليوم</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->emp_name }}</td>
                            <td>
                                <input type="date"
                                       name="attendance[{{ $employee->id }}][day]"
                                       class="form-control"
                                       min="{{ $open_period->START_DATE_M }}"
                                       max="{{ $open_period->END_DATE_M }}">
                            </td>
                                                        <td>
                                <select name="attendance[{{ $employee->id }}][status]" class="form-control">
                                    <option value="present">حاضر</option>
                                    <option value="absent">غائب</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-success">حفظ الحضور</button>
            </form>
        @else
            <div class="alert alert-warning">لا توجد فترة مفتوحة حاليًا</div>
        @endif
    </div>
</div>
</div>
@endsection
