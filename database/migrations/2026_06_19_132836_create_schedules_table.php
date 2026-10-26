<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Hoca
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Ders
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade'); // Sınıf
            
            $table->enum('type', ['lesson', 'exam'])->default('lesson');
            $table->string('day'); // Pazartesi, Salı vs.
            $table->time('start_time');
            $table->time('end_time');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};