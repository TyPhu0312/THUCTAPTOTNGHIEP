<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('student');
        
        Schema::create('student', function (Blueprint $table) {
            $table->uuid('student_id')->primary();
            $table->string('student_code')->unique();
            $table->string('full_name');
            $table->string('school_email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student');
    }
}; 