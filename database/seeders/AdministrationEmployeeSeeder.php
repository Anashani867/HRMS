<?php

namespace Database\Seeders;
use App\Models\Employee;
use App\Models\Departement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministrationEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee = Employee::find(1); // الحصول على الموظف الذي ترغب في تعيينه
        $department = Departement::find(1); // الحصول على القسم الذي ستعين فيه الموظف
    
        AdministrationEmployee::create([
            'employee_id' => $employee->id,
            'department_id' => $department->id,
            'assigned_at' => now(),
        ]);    }
}
