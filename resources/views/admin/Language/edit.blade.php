@extends('layouts.admin')
@section('title', 'تعديل الغات')

@section('contentheader', 'تعديل بيانات الغات')

@section('contentheaderactivelink')
<a href="{{ route('centers.index') }}">قائمة الغات</a>
@endsection

@section('contentheaderactive', 'تعديل')

@section('content')
<div class="container">
    <h2>تعديل اللغة</h2>

    <form action="{{ route('languages.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">اسم اللغة</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $data->name) }}" required>
        </div>

        <div class="col-md-12">
            <div class="form-group">
               <label> حالة التفعيل</label>
               <select name="active" id="active" class="form-control">
               <option @if(old('active',$data['active'])==1) selected @endif  value="1">مفعل</option>
               <option  @if(old('active',$data['active'])==0) selected @endif  value="0">معطل</option>
               </select>
               @error('active')
               <span class="text-danger">{{ $message }}</span> 
               @enderror
            </div>
         </div>

        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection
