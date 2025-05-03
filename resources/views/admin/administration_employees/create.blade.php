@extends('layouts.admin')
@section('title', 'ضافةدة موظفو الإدارة')

@section('contentheader', 'إضافة موظفو الإدارة')

@section('contentheaderactivelink')
<a href="{{ route('administration_employees.index') }}">قائمة موظفو الإدارة</a>
@endsection

@section('contentheaderactive', 'إضافة')


@section('content')
    <div class="container">
        <h2>إنشاء موظف إداري</h2>

        <form action="{{ route('administration_employees.store') }}" method="POST">
            @csrf
            
            <select name="employee_id" class="form-control">
                <option value="">اختر موظفو الإدارة</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                @endforeach
            </select>
            

            <div class="form-group">
                <label for="department_id">القسم:</label>
                <select name="department_id" class="form-control" required>
                    <option value="">اختر قسم</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="assigned_at">تاريخ التعيين:</label>
                <input type="date" name="assigned_at" class="form-control" />
            </div>

            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>
@endsection
