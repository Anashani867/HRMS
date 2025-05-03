@extends('layouts.admin')
@section('title', 'تعديل دولة')

@section('contentheader', 'تعديل بيانات الدولة')

@section('contentheaderactivelink')
<a href="{{ route('countries.index') }}">قائمة الدول</a>
@endsection

@section('contentheaderactive', 'تعديل')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">تعديل بيانات الدولة</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('countries.update', $data->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>اسم الدولة</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $data->name) }}" required>
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

                <div class="form-group text-center">
                    <button class="btn btn-sm btn-success" type="submit">تعديل</button>
                    <a href="{{ route('countries.index') }}" class="btn btn-sm btn-danger">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
