@extends('layouts.admin')
@section('title')
المحافظات
@endsection
@section('contentheader')
قائمة الضبط
@endsection
@section('contentheaderactivelink')
<a href="{{ route('governorates.index') }}">المحافظات</a>
@endsection
@section('contentheaderactive')
تعديل
@endsection
@section('content')
<div class="col-12">
   <div class="card">
      <div class="card-header">
         <h3 class="card-title card_title_center">تعديل بيانات محافظة</h3>
      </div>
      <div class="card-body">
         <form action="{{ route('governorates.update', $governorate->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="col-md-12">
               <div class="form-group">
                  <label>اسم المحافظة</label>
                  <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $governorate->name) }}" required>
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>

            <div class="col-md-12">
               <div class="form-group">
                  <label>الدولة</label>
                  <select name="countires_id" id="countires_id" class="form-control" required>
                     @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('countires_id', $governorate->countires_id) == $country->id ? 'selected' : '' }}>
                           {{ $country->name }}
                        </option>
                     @endforeach
                  </select>
                  @error('countires_id')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>

            <div class="col-md-12">
               <div class="form-group">
                  <label>حالة التفعيل</label>
                  <select name="active" id="active" class="form-control">
                     <option value="1" {{ old('active', $governorate->active) == 1 ? 'selected' : '' }}>مفعل</option>
                     <option value="0" {{ old('active', $governorate->active) == 0 ? 'selected' : '' }}>معطل</option>
                  </select>
                  @error('active')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>

            <div class="col-md-12">
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-sm btn-success">تعديل المحافظة</button>
                  <a href="{{ route('governorates.index') }}" class="btn btn-danger btn-sm">إلغاء</a>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
