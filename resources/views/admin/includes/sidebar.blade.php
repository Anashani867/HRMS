
@php
    $open_period = session('open_period');
@endphp

<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name; }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <li class="nav-item has-treeview    {{ ( request()->is('admin/generalSettings*') || request()->is('admin/finance_calender*') || request()->is('admin/branches*') || request()->is('admin/ShiftsTypes*') || request()->is('admin/departements*')  || request()->is('admin/jobs_categories*') || request()->is('admin/Qualifications*') || request()->is('admin/occasions*') || request()->is('admin/Resignations*') || request()->is('admin/Nationalities*') || request()->is('admin/Religions*')) ? 'menu-open':'' }} ">
          <a href="#" class="nav-link {{ ( request()->is('admin/generalSettings*') || request()->is('admin/finance_calender*') || request()->is('admin/branches*') || request()->is('admin/ShiftsTypes*') || request()->is('admin/departements*') || request()->is('admin/jobs_categories*')  || request()->is('admin/Qualifications*') ||request()->is('admin/occasions*') || request()->is('admin/Resignations*') || request()->is('admin/Nationalities*') || request()->is('admin/Religions*') ) ? 'active':'' }} ">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
             قائمة الضبط
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin_panel_settings.index') }}" class="nav-link {{ (request()->is('admin/generalSettings*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>الضبط العام</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('finance_calender.index') }}" class="nav-link  {{ (request()->is('admin/finance_calender*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p> السنوات المالية</p>
              </a>
            </li>

             <li class="nav-item">
               <a href="{{ route('countries.index') }}" class="nav-link {{ request()->is('admin/countries*') ? 'active' : '' }}">
                 <i class="far fa-circle nav-icon"></i>
                 <p>الدول</p>
               </a>
             </li>
             
             <li class="nav-item">
               <a href="{{ route('governorates.index') }}" class="nav-link {{ request()->is('admin/governorates*') ? 'active' : '' }}">
                 <i class="far fa-circle nav-icon"></i>
                 <p>المحافظات</p>
               </a>
             </li>
             
             <li class="nav-item">
               <a href="{{ route('centers.index') }}" class="nav-link {{ request()->is('admin/centers*') ? 'active' : '' }}">
                 <i class="far fa-circle nav-icon"></i>
                 <p>المراكز</p>
               </a>
             </li>

            <li class="nav-item">
              <a href="{{ route('branches.index') }}" class="nav-link  {{ (request()->is('admin/branches*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>  الفروع</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('ShiftsTypes.index') }}" class="nav-link  {{ (request()->is('admin/ShiftsTypes*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>  انواع الشفتات</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('departements.index') }}" class="nav-link  {{ (request()->is('admin/departements*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>   ادارات الموظفين</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('jobs_categories.index') }}" class="nav-link  {{ (request()->is('admin/jobs_categories*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>     وظائف الموظفين</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('languages.index') }}" class="nav-link  {{ (request()->is('admin/jobs_categories*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>     لغات الموظفين</p>
              </a>
            </li>
           
            <li class="nav-item">
              <a href="{{ route('Qualifications.index') }}" class="nav-link  {{ (request()->is('admin/Qualifications*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>     مؤهلات الموظفين</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('occasions.index') }}" class="nav-link  {{ (request()->is('admin/occasions*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>      المناسبات الرسمية</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('Resignations.index') }}" class="nav-link  {{ (request()->is('admin/Resignations*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>       أنواع ترك العمل</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('Nationalities.index') }}" class="nav-link  {{ (request()->is('admin/Nationalities*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>       أنواع الجنسيات</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('Religions.index') }}" class="nav-link  {{ (request()->is('admin/Religions*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>       أنواع الديانات</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview    {{ ( request()->is('admin/Employees*') || request()->is('admin/AddtionalTypes*') ) ? 'menu-open' : '' }} ">
          <a href="#" class="nav-link {{ ( request()->is('admin/Employees*') || request()->is('admin/AddtionalTypes*') ) ? 'active' : '' }} ">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
             قائمة شئون الموظفين
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('Employees.index') }}" class="nav-link {{ (request()->is('admin/Employees*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p> بيانات الموظفين</p>
              </a>
            </li>
            
            <li class="nav-item">
              <a href="{{ route('administration_employees.index') }}" class="nav-link {{ (request()->is('admin/administration_employees*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p> بيانات موظفين الادارة</p>
              </a>
            </li>
            
            <li class="nav-item">
              <a href="{{ route('AddtionalTypes.index') }}" class="nav-link {{ (request()->is('admin/AddtionalTypes*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p> انواع الاضافي للراتب</p>
              </a>
            </li>
           

            <li class="nav-item">
              <a href="{{ route('DiscountsTypes.index') }}" class="nav-link {{ (request()->is('admin/DiscountsTypes*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p> انواع الخصم للراتب</p>
              </a>
            </li>    
            
            <li class="nav-item">
              <a href="{{ route('employee.salary.add') }}" class="nav-link {{ (request()->is('admin/employee.salary.add*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>  الاضافي للراتب</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('employee.salary.add.deduction') }}" 
                 class="nav-link {{ (request()->is('admin/employee.salary/add*'))?'active':'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>خصم للراتب</p>
              </a>
          </li>
            <li class="nav-item">
              <a href="{{ route('attendances.index') }}" class="nav-link {{ (request()->is('admin/generalSettings*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>    بيانات الحضور </p>
              </a>
            </li> 

            @if($open_period)
    <a href="{{ route('attendance.report.index', ['period_id' => $open_period->id]) }}" class="nav-link">
        <i class="nav-icon fas fa-calendar-check"></i>
        <p>تقرير الحضور</p>
    </a>
@else
    <a href="#" class="nav-link disabled">
        <i class="nav-icon fas fa-calendar-check"></i>
        <p>تقرير الحضور</p>
    </a>
@endif

        

          </ul>
        </li>

        <li class="nav-item has-treeview    {{ ( request()->is('admin/MainSalaryRecord*')  ) ? 'menu-open' : '' }} ">
          <a href="#" class="nav-link {{ ( request()->is('admin/MainSalaryRecord*')  ) ? 'active' : '' }} ">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
             قائمة الاجور
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('MainSalaryRecord.index') }}" class="nav-link {{ (request()->is('admin/Employees*'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>  السجلات الرئيسية لرواتب</p>
              </a>
            </li>
            
            

          
           

          </ul>
        </li>


       
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>