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
        Schema::create('assigned_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->unsignedBigInteger('empId')->constrained('users');
            $table->text('taskDescription');
            $table->string('priority');
            $table->date('deadline');
            $table->unsignedBigInteger('assignedBy')->constrained('users');
            $table->string('status');//0=no-progress,1=in-progress,2=on-hold,3=completed
            $table->time('startTime')->nullable();
            $table->time('endTime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_tasks');
    }
};
