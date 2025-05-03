@extends('layouts.admin')
@section('title')
محافظة
@endsection
@section('contentheader')
قائمة الضبط
@endsection
@section('contentheaderactivelink')
<a href="{{ route('governorates.index') }}">   محافظة</a>
@endsection
@section('contentheaderactive')
تعديل محافظة
@endsection
@section('content')
<div class="col-12">
    <div class="card">
       <div class="card-header">
          <h3 class="card-title card_title_center">  تعديل محافظة
          </h3>
       </div>
       <div class="card-body">
    <form action="{{ route('governorates.update', $data->id) }}" method="POST">
    @csrf

    <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>

    <div class="form-group">
    <label for="countires_id">اختر المحافظة</label>
    <select name="countires_id" class="form-control"  required>
        @foreach($countries as $country)
            <option value="{{ $country->id }}" {{ $country->id == $data->countires_id ? 'selected' : '' }}>
                {{ $country->name }}
            </option>
        @endforeach
    </select>
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

    <button class="btn btn-sm btn-success" type="submit">حفظ</button>
    <a href="{{ route('governorates.index') }}" class="btn btn-sm btn-danger">إلغاء</a>
</div>

</form>

</div>
</div>
</div>
@endsection
