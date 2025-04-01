<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('student', function (Blueprint $table) {
            $table->string('school_email')->unique()->after('full_name');
            $table->string('phone')->unique()->after('school_email');
            $table->string('password')->after('phone');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('student', function (Blueprint $table) {
            $table->dropColumn(['school_email', 'phone', 'password', 'remember_token']);
            $table->dropTimestamps();
        });
    }
}; 