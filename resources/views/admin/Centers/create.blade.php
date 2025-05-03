@extends('layouts.admin')
@section('title', 'إضافة مركز جديد')

@section('contentheader', 'إضافة مركز')

@section('contentheaderactivelink')
<a href="{{ route('centers.index') }}">قائمة المراكز</a>
@endsection

@section('contentheaderactive', 'إضافة')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">إضافة مركز جديد</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('centers.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>اسم المركز</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

            
                <div class="form-group">
                    <label>المحافظة</label>
                    <select name="governorates_id" class="form-control" required>
                        <option value="">اختر المحافظة</option>
                        @foreach($governorates as $gov)
                            <option value="{{ $gov->id }}">{{ $gov->name }}</option>
                        @endforeach
                    </select>
                    
                </div>

                <div class="form-group">
                    <label>الحالة</label>
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" name="active" value="1" checked> نشط
                </div>

                <div class="form-group text-center">
                    <button class="btn btn-sm btn-success" type="submit">إضافة</button>
                    <a href="{{ route('centers.index') }}" class="btn btn-sm btn-danger">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
