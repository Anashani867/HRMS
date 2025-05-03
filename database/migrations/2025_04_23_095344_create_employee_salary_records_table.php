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
    Schema::create('employee_salary_records', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('employee_id');
        $table->decimal('total_salary', 10, 2);
        $table->date('date');
        $table->unsignedBigInteger('com_code');
        $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salary_records');
    }
};
