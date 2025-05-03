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
        Schema::table('administration_employees', function (Blueprint $table) {
            $table->bigInteger('com_code')->nullable()->after('id'); // أو حسب ترتيبك
            $table->bigInteger('added_by')->nullable()->after('com_code');
            $table->bigInteger('updated_by')->nullable()->after('added_by');
        });
    }
    
    public function down()
    {
        Schema::table('administration_employees', function (Blueprint $table) {
            $table->dropColumn(['com_code', 'added_by', 'updated_by']);
        });
    }
    
};
