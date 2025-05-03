@extends('layouts.admin')
@section('title')
    أنواع خصم
@endsection
@section('contentheader')
    قائمة الموظفين
@endsection
@section('contentheaderactivelink')
    <a href="{{ route('employee.salary.add.store') }}">إضافي للراتب</a>
@endsection
@section('contentheaderactive')
    إضافة
@endsection
@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">إضافي للراتب</h2>

        <form action="{{ route('employee.salary.add.store') }}" method="POST" class="shadow-sm p-4 bg-white rounded">
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
                <label for="adtional_type_id">اختار نوع الإضافي</label>
                <select name="adtional_type_id" id="adtional_type_id" class="form-control">
                    @foreach($adtionalTypes as $type)
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
