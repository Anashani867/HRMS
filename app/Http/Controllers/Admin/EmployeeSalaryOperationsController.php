<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\AdditionType;
use App\Models\DiscountType;
use App\Models\EmployeeSalaryAddition;
use App\Models\EmployeeSalaryDiscount;

class EmployeeSalaryOperationsController extends Controller
{
    public function create()
    {
        $employees = Employee::all();
        $additionTypes = AdditionType::all();
        $discountTypes = DiscountType::all();

        return view('admin.employee_salary_operations.create', compact('employees', 'additionTypes', 'discountTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'operation_type' => 'required|in:addition,discount',
            'type_id' => 'required',
            'value' => 'required|numeric',
            'date' => 'required|date',
        ]);

        if ($request->operation_type == 'addition') {
            EmployeeSalaryAddition::create([
                'employee_id' => $request->employee_id,
                'adtional_type_id' => $request->type_id,
                'value' => $request->value,
                'date' => $request->date,
                'notes' => $request->notes,
                'added_by' => auth()->user()->id,
                'com_code' => auth()->user()->com_code,
            ]);
        } elseif ($request->operation_type == 'discount') {
            EmployeeSalaryDiscount::create([
                'employee_id' => $request->employee_id,
                'discount_type_id' => $request->type_id,
                'value' => $request->value,
                'date' => $request->date,
                'notes' => $request->notes,
                'added_by' => auth()->user()->id,
                'com_code' => auth()->user()->com_code,
            ]);
        }

        return redirect()->back()->with('success', 'تمت العملية بنجاح.');
    }
}
