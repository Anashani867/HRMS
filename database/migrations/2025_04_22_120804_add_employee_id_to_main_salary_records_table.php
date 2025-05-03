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
    Schema::table('main_salary_records', function (Blueprint $table) {
        $table->unsignedBigInteger('employee_id')->nullable(); // إضافة العمود
    });
}

public function down()
{
    Schema::table('main_salary_records', function (Blueprint $table) {
        $table->dropColumn('employee_id'); // إزالة العمود في حالة التراجع
    });
}

};
