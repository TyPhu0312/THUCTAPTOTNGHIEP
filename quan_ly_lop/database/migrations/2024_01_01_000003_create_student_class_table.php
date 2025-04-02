<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_class', function (Blueprint $table) {
            $table->uuid('student_class_id')->primary();
            $table->foreignUuid('student_id')->constrained('student', 'student_id');
            $table->foreignUuid('class_id')->constrained('classroom', 'class_id');
            $table->date('enrolled_at');
            $table->enum('status', ['Active', 'Drop', 'Completed'])->default('Active');
            $table->float('final_score')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_class');
    }
}; 