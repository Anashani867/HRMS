@extends('layouts.admin')
@section('title', 'المراكز')

@section('contentheader', 'قائمة المراكز')

@section('contentheaderactivelink')
<a href="{{ route('centers.create') }}">إضافة مركز جديد</a>
@endsection

@section('contentheaderactive', 'عرض المراكز')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">قائمة المراكز</h3>
            <a href="{{ route('centers.create') }}" class="btn btn-sm btn-success" style="float: left;">إضافة محافظة جديدة</a>

        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>المحافظة</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $center)
                        <tr>
                            <td>{{ $center->name }}</td>
                            <td>{{ $center->governorate->name ?? '-' }}</td>
                            <td>{{ $center->active ? 'نشط' : 'غير نشط' }}</td>
                            <td>
                                <a href="{{ route('centers.edit', $center->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                <form action="{{ route('centers.destroy', $center->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('هل أنت متأكد؟')" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
