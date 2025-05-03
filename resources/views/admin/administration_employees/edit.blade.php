@extends('layouts.admin')
@section('title', 'تعديل موظفو الإدارة')

@section('contentheader', 'تعديل بيانات موظفو الإدارة')

@section('contentheaderactivelink')
<a href="{{ route('administration_employees.index') }}">قائمة موظفو الإدارة</a>
@endsection

@section('contentheaderactive', 'تعديل')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">تعديل بيانات موظفوا الإدارة</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('administration_employees.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT') 
            
                <select name="employee_id" class="form-control">
                    <option value="">اختر موظفوا الإدارة</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" @if($employee->id == $data->employee_id) selected @endif>
                            {{ $employee->emp_name }}
                        </option>
                    @endforeach
                </select>
            
                <div class="form-group">
                    <label for="department_id">القسم:</label>
                    <select name="department_id" class="form-control" required>
                        <option value="">اختر قسم</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" @if($department->id == $data->department_id) selected @endif>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            
                <div class="col-md-12">
                    <div class="form-group">
                        <label>حالة التفعيل</label>
                        <select name="active" id="active" class="form-control">
                            <option @if(old('active', $data['active']) == 1) selected @endif value="1">مفعل</option>
                            <option @if(old('active', $data['active']) == 0) selected @endif value="0">معطل</option>
                        </select>
                        @error('active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            
                <div class="form-group text-center">
                    <button class="btn btn-sm btn-success" type="submit">تعديل</button>
                    <a href="{{ route('administration_employees.index') }}" class="btn btn-sm btn-danger">إلغاء</a>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection
