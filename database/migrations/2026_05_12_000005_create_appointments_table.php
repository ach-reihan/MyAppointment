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
        Schema::create('appointments', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('clinic_id')->constrained()->cascadeOnDelete();

            $table->timestampTz('appointment_datetime');
            $table->text('complaint');

            $table->enum('status', ['pending', 'approved', 'cancelled', 'completed'])->default('pending');
            $table->timestamps();

            $table->index(['doctor_id', 'status']);
            $table->index(['patient_id', 'appointment_datetime']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
