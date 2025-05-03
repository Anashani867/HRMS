@extends('layouts.admin')
@section('title')
    خصم
@endsection
@section('contentheader')
    قائمة الموظفين
@endsection
@section('contentheaderactivelink')
    <a href="{{ route('DiscountsTypes.index') }}">خصم للراتب</a>
@endsection
@section('contentheaderactive')
    خصم
@endsection
@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">خصم للراتب</h2>

        <form action="{{ route('employee.salary.deduction.store') }}" method="POST" class="shadow-sm p-4 bg-white rounded">
            @csrf

            <div class="form-group mb-3">
                <label for="employee_id">اختار الموظف</label>
                <select name="employee_id" id="employee_id" class="form-control">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="discounts_types_id">اختار نوع الخصم</label>
                <select name="discounts_types_id" id="discounts_types_id" class="form-control">
                    @foreach($DiscountsType as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="value">القيمة</label>
                <input type="number" name="value" id="value" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="date">التاريخ</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="notes">ملاحظات</label>
                <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg">حفظ</button>
            </div>
        </form>
    </div>
@endsection
