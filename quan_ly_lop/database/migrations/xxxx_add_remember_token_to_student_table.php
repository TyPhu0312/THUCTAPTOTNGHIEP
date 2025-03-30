<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('student', function (Blueprint $table) {
            if (!Schema::hasColumn('student', 'remember_token')) {
                $table->rememberToken();
            }
        });
    }

    public function down()
    {
        Schema::table('student', function (Blueprint $table) {
            $table->dropRememberToken();
        });
    }
}; 