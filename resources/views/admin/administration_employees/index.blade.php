@extends('layouts.admin')
@section('title', 'موظفو الإدارة')

@section('contentheader', 'قائمة موظفو الإدارة')

@section('contentheaderactivelink')
<a href="{{ route('administration_employees.create') }}">إضافة دولة جديدة</a>
@endsection

@section('contentheaderactive', 'عرض موظفو الإدارة')


@section('content')
<div class="container">
    <div class="card-header">
        <h3 class="card-title card_title_center">  انشاء  موظفو الإدارة 
           <a href="{{ route('administration_employees.create') }}" class="btn btn-sm btn-warning">اضافة جديد</a>
        </h3>
     </div>
    <h2 class="mb-4"> </h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم موظفو الإدارة</th>
                <th>اسم القسم</th>
                <th>تاريخ التعيين</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $adminEmployee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $adminEmployee->employee->emp_name ?? 'غير موجود' }}</td>
                    <td>{{ $adminEmployee->department->name ?? 'غير موجود' }}</td>
                    <td>{{ $adminEmployee->assigned_at }}</td>
                    <td>
                        <a href="{{ route('administration_employees.edit', $adminEmployee->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                        <form action="{{ route('administration_employees.destroy', $adminEmployee->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('هل أنت متأكد من الحذف؟');" class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">لا يوجد موظفون بعد.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

