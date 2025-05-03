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
عرض
@endsection
@section('content')

<div class="col-12">
   <div class="card">
      <div class="card-header">
         <h3 class="card-title card_title_center">قائمة المحافظات</h3>
         <a href="{{ route('governorates.create') }}" class="btn btn-sm btn-success" style="float: left;">إضافة محافظة جديدة</a>
      </div>

      <div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered table-striped">
               <thead>
                  <tr>
                     <th>الاسم</th>
                     <th>الدولة</th>
                     <th>الحالة</th>
                     <th class="text-center">العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  @forelse($data as $gov)
                  <tr>
                     <td>{{ $gov->name }}</td>
                     <td>{{ $gov->country->name ?? '-' }}</td>
                     <td>
                        @if($gov->active)
                           <span class="badge badge-success">نشطة</span>
                        @else
                           <span class="badge badge-danger">غير نشطة</span>
                        @endif
                     </td>
                     <td class="text-center">
                        <a href="{{ route('governorates.edit', $gov->id) }}" class="btn btn-sm btn-primary">تعديل</a>

                        {{-- <form action="{{ route('governorates.destroy', $gov->id) }}" method="POST" style="display:inline-block;">
                           @csrf
                           @method('DELETE')
                           <button onclick="return confirm('هل أنت متأكد من الحذف؟')" class="btn btn-sm btn-danger">حذف</button>
                        </form> --}}

                        <a  href="{{ route('governorates.destroy',$gov->id) }}" class="btn are_you_shur  btn-danger btn-sm">حذف</a>

                     </td>
                  </tr>
                  @empty
                  <tr>
                     <td colspan="4" class="text-center">لا توجد بيانات</td>
                  </tr>
                  @endforelse
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

@endsection
