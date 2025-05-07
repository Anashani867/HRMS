<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministrationEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administration_employees', function (Blueprint $table) {
            $table->id(); // معرف فريد للسجل
            $table->unsignedBigInteger('employee_id'); // ربط الموظف
            $table->unsignedBigInteger('department_id')->nullable(); // ربط القسم مع السماح بأن يكون فارغًا
            $table->date('assigned_at')->nullable(); // تاريخ التعيين (يمكن أن يكون فارغًا)
            $table->integer('com_code'); // كود الشركة
            $table->string('added_by')->nullable(); // الشخص الذي أضاف السجل
            $table->bigInteger('updated_by')->nullable(); // الشخص الذي حدث السجل
            $table->timestamps(); // التاريخ والوقت الخاص بإنشاء وتحديث السجل

            // تحديد المفتاح الأجنبي للموظف
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            
            // تحديد المفتاح الأجنبي للقسم مع حذف البيانات عند الحذف
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administration_employees');
    }
}
