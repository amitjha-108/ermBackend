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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client')->nullable();
            $table->string('location')->nullable();
            $table->string('startDate')->nullable();
            $table->string('endDate')->nullable();
            $table->string('status')->nullable(); //0=not started, 1= started, 2 =partially completed, 3=completed
            $table->string('projectType')->nullable();
            $table->text('projectDescription')->nullable();
            $table->string('projectScope')->nullable();
            $table->string('projectNature')->nullable();
            $table->string('projectCost')->nullable();
            $table->string('developmentArea')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
