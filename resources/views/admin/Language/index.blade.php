@extends('layouts.admin')
@section('title')
فئات الغات
@endsection
@section('contentheader')
قائمة الضبط
@endsection
@section('contentheaderactivelink')
<a href="{{ route('languages.index') }}">   الغات</a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="container">
    <h2>اللغات</h2>
    <a href="{{ route('languages.create') }}" class="btn btn-success mb-3">إضافة لغة جديدة</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>الحالة</th>
                <th>تاريخ الإضافة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $language)
            <tr>
                <td>{{ $language->name }}</td>
                <td>{{ $language->active ? 'مفعل' : 'غير مفعل' }}</td>
                <td>{{ $language->created_at }}</td>
                <td>
                    <a href="{{ route('languages.edit', $language->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                    <form action="{{ route('languages.destroy', $language->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('هل أنت متأكد؟')" class="btn btn-danger btn-sm">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

