@extends('layouts.admin')
@section('title', 'الدول')

@section('contentheader', 'قائمة الدول')

@section('contentheaderactivelink')
<a href="{{ route('countries.create') }}">إضافة دولة جديدة</a>
@endsection

@section('contentheaderactive', 'عرض الدول')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">قائمة الدول</h3>
            <a href="{{ route('countries.create') }}" class="btn btn-sm btn-success" style="float: left;">إضافة محافظة جديدة</a>

        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $country)
                        <tr>
                            <td>{{ $country->name }}</td>
                            <td>{{ $country->active ? 'نشطة' : 'غير نشطة' }}</td>
                            <td>
                                <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                {{-- <form action="{{ route('countries.destroy', $country->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('هل أنت متأكد؟')" class="btn btn-sm btn-danger">حذف</button>
                                </form> --}}
                                <a  href="{{ route('countries.destroy',$country->id) }}" class="btn are_you_shur  btn-danger btn-sm">حذف</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
