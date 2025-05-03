@extends('layouts.admin')
@section('title', 'إضافة دولة جديدة')

@section('contentheader', 'إضافة دولة')

@section('contentheaderactivelink')
<a href="{{ route('countries.index') }}">قائمة الدول</a>
@endsection

@section('contentheaderactive', 'إضافة')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">إضافة دولة جديدة</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('countries.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>اسم الدولة</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>الحالة</label>
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" name="active" value="1" checked> نشط
                </div>

                <div class="form-group text-center">
                    <button class="btn btn-sm btn-success" type="submit">إضافة</button>
                    <a href="{{ route('countries.index') }}" class="btn btn-sm btn-danger">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
