<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classroom', function (Blueprint $table) {
            $table->uuid('class_id')->primary();
            $table->string('class_code')->unique();
            $table->foreignUuid('course_id')->constrained('course', 'course_id');
            $table->string('semester');
            $table->integer('year');
            $table->enum('status', ['Active', 'Completed', 'Cancelled'])->default('Active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('classroom');
    }
}; 