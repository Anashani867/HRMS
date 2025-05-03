<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


    /**
     * Reverse the migrations.
     */
    
    public function up()
    {
        Schema::table('employee_salary_records', function (Blueprint $table) {
            $table->foreignId('main_salary_record_id')->nullable()->constrained('main_salary_records')->onDelete('cascade');
            $table->decimal('total_additions', 10, 2)->default(0);
            $table->decimal('total_deductions', 10, 2)->default(0);
            $table->decimal('final_salary', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('added_by')->nullable()->constrained('admins');
            $table->foreignId('updated_by')->nullable()->constrained('admins');
        });
    }
    
    public function down()
    {
        Schema::table('employee_salary_records', function (Blueprint $table) {
            $table->dropColumn([
                'main_salary_record_id',
                'total_additions',
                'total_deductions',
                'final_salary',
                'notes',
                'added_by',
                'updated_by',
            ]);
        });
    }
    
};
