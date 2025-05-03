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
        Schema::create('main_salary_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('period_id');
            $table->unsignedBigInteger('com_code');
            $table->boolean('is_open')->default(0); // 0 = مغلق، 1 = مفتوح
            $table->timestamp('opened_at')->nullable();
    
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
    
            $table->timestamps();
    
            // علاقات foreign key (اختياري)
            $table->foreign('period_id')->references('id')->on('finance_cln_periods')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_salary_records');
    }
};
