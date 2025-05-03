@extends('layouts.admin')
@section('title', 'إضافة لغات جديد')

@section('contentheader', 'إضافة لغات')

@section('contentheaderactivelink')
<a href="{{ route('languages.index') }}">قائمة الغات</a>
@endsection

@section('contentheaderactive', 'إضافة')

@section('content')
<div class="container">
    <h2>{{ isset($language) ? 'تعديل اللغة' : 'إضافة لغة' }}</h2>

    <form action="{{ isset($data) ? route('languages.update', $data->id) : route('languages.store') }}" method="POST">
        @csrf
        @if(isset($data))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">اسم اللغة</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $language->name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label>الحالة</label>
            <input type="hidden" name="active" value="0">
            <input type="checkbox" name="active" value="1" checked> نشط
        </div>

        <button class="btn btn-sm btn-success" type="submit" name="submit">اضف الوظيفة </button>
    </form>
</div>
@endsection