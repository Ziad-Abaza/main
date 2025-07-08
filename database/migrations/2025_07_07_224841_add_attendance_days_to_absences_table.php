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
        Schema::table('absences', function (Blueprint $table) {
            $table->integer('attendance_days')->default(1);
        });
    }

    public function down()
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropColumn('attendance_days');
        });
    }
};
