<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('employee_salary_records', function (Blueprint $table) {
            $table->string('addition_type')->nullable(); // إضافة العمود addition_type
            $table->decimal('addition_amount', 10, 2)->nullable(); // إضافة العمود addition_amount
            $table->string('deduction_type')->nullable(); // إضافة العمود deduction_type
            $table->decimal('deduction_amount', 10, 2)->nullable(); // إضافة العمود deduction_amount
        });
    }
    
    public function down()
    {
        Schema::table('employee_salary_records', function (Blueprint $table) {
            $table->dropColumn(['addition_type', 'addition_amount', 'deduction_type', 'deduction_amount']);
        });
    }
    
};
