<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke tabel participants
            $table->foreignId('participant_id')
                  ->constrained()
                  ->cascadeOnDelete();
                  
            // Foreign key ke tabel courses
            $table->foreignId('course_id')
                  ->constrained()
                  ->cascadeOnDelete();
                  
            $table->string('status', 20)->default('registered');
            $table->timestamps();

            // Mencegah peserta yang sama mendaftar kursus yang sama 2x
            $table->unique(['participant_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};