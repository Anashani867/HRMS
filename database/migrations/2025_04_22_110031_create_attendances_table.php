<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');      // الموظف
            $table->unsignedBigInteger('period_id');        // الفترة المالية المفتوحة
            $table->date('day');                            // تاريخ اليوم
            $table->enum('status', ['present', 'absent']);  // حاضر أو غائب
            $table->timestamps();

            // علاقات
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('period_id')->references('id')->on('finance_cln_periods')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
