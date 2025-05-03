@extends('layouts.admin')
@section('title')
الاجور
@endsection
@section('contentheader')
قائمة الاجور
@endsection
@section('contentheaderactivelink')
<a href="{{ route('ShiftsTypes.index') }}"> السجلات الرئيسية</a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="col-12">
   <div class="card">
      <div class="card-header">
         <h3 class="card-title card_title_center">  بيانات السجلات الرئيسسة للرواتب</h3>
      </div>
      <div class="row" style="padding: 5px;">
         <div class="col-md-3">
            <div class="form-group">
               <label> السنة المالية </label>
               <select name="type_search" id="type_search" class="form-control">
                  <option value="all"> بحث بالكل</option>
                  <option value="1">صباحي</option>
                  <option value="2">مسائي</option>
               </select>
            </div>
         </div>
      </div>
      <div class="card-body" id="ajax_responce_serachDiv">
         @if(@isset($data) and !@empty($data) and count($data)>0 )
         <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
               <th> اسم الشهر عربي</th>
               <th> اسم الشهر انجليزي</th>
               <th> تاريخ البداية </th>
               <th> تاريخ النهاية </th>
               <th> البداية البصمة</th>
               <th> النهاية البصمة</th>
               <th> عدد الايام</th>
               <th> حالة الشهر</th>
            </thead>
            <tbody>
               @foreach ($data as $info)
               @php
                   $salary_record = \App\Models\MainSalaryRecord::where('period_id', $info->id)
                                       ->where('com_code', auth()->user()->com_code)
                                       ->first();
               @endphp
               <tr>
                   <td>{{ $info->Month->name }}</td>
                   <td>{{ $info->Month->name_en }}</td>
                   <td>{{ $info->START_DATE_M }}</td>
                   <td>{{ $info->END_DATE_M }}</td>
                   <td>{{ $info->start_date_for_pasma }}</td>
                   <td>{{ $info->end_date_for_pasma }}</td>
                   <td>{{ $info->number_of_days }}</td>
                   <td>
                       @if($salary_record)
                           @if($salary_record->is_open == 1)
                               <span class="badge bg-success">مفتوح</span>
                               <form action="{{ route('MainSalaryRecord.close', $info->id) }}" method="POST" style="display:inline-block;">
                                   @csrf
                                   <button type="submit" class="btn btn-danger btn-sm">إغلاق البصمة</button>
                               </form>
                           @elseif($salary_record->is_open == 0)
                               <span class="badge bg-secondary">مغلق</span>
                           @elseif($salary_record->is_open == 2)
                               <span class="badge bg-dark">مؤرشف</span>
                           @endif
                       @else
                           <form action="{{ route('MainSalaryRecord.open', $info->id) }}" method="POST" style="display:inline-block;">
                               @csrf
                               <button type="submit" class="btn btn-primary btn-sm">فتح سجل الرواتب</button>
                           </form>
                       @endif
                   </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         <br>
         <div class="col-md-12 text-center">
            {{ $data->links('pagination::bootstrap-5') }}
         </div>
         @else
         <p class="bg-danger text-center"> عفوا لاتوجد بيانات لعرضها</p>
         @endif
         
         @if($open_period)
         <h4>الفترة المفتوحة: {{ $open_period->Month->name }} ({{ $open_period->START_DATE_M }} - {{ $open_period->END_DATE_M }})</h4>

         <form action="{{ route('attendance.store') }}" method="POST">
             @csrf
             <input type="hidden" name="period_id" value="{{ $open_period->id }}">
             <table class="table table-bordered">
                 <thead>
                     <tr>
                         <th>اسم الموظف</th>
                         <th>تاريخ اليوم</th>
                         <th>الحالة</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach($employees as $employee)
                     <tr>
                         <td>{{ $employee->emp_name }}</td>
                         <td><input type="date" name="attendance[{{ $employee->id }}][day]" class="form-control"></td>
                         <td>
                             <select name="attendance[{{ $employee->id }}][status]" class="form-control">
                                 <option value="present">حاضر</option>
                                 <option value="absent">غائب</option>
                             </select>
                         </td>
                     </tr>
                     @endforeach
                 </tbody>
             </table>
             <button type="submit" class="btn btn-success">حفظ الحضور</button>
         </form>
         @else
         <div class="alert alert-warning">لا توجد فترة مفتوحة حاليًا</div>
         @endif
         
      </div>
   </div>
</div>
@endsection
@section('script')
<script>
   $(document).ready(function(){
   
      $(document).on('change','#type_search',function(e){
         ajax_search();
      });
      $(document).on('input','#hour_from_range',function(e){
         ajax_search();
      });
   
      $(document).on('input','#hour_to_range',function(e){
         ajax_search();
      });
   
   function ajax_search(){
   var type_search=$("#type_search").val();
   var hour_from_range=$("#hour_from_range").val();
   var hour_to_range=$("#hour_to_range").val();
   jQuery.ajax({
   url:'{{ route('ShiftsTypes.ajax_search') }}',
   type:'post',
   'dataType':'html',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',type_search:type_search,hour_from_range:hour_from_range,hour_to_range:hour_to_range},
   success: function(data){
   $("#ajax_responce_serachDiv").html(data);
   },
   error:function(){
   alert("عفوا لقد حدث خطأ ");
   }
   
   });
}
   $(document).on('click','#ajax_pagination_in_search a',function(e){
   e.preventDefault();
   var type_search=$("#type_search").val();
   var hour_from_range=$("#hour_from_range").val();
   var hour_to_range=$("#hour_to_range").val();
   var linkurl=$(this).attr("href");
   jQuery.ajax({
   url:linkurl,
   type:'post',
   'dataType':'html',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',type_search:type_search,hour_from_range:hour_from_range,hour_to_range:hour_to_range},
   success: function(data){
   $("#ajax_responce_serachDiv").html(data);
   },
   error:function(){
   alert("عفوا لقد حدث خطأ ");
   }
   
   });
   
   });
   
   });
   
   
</script>
@endsection
