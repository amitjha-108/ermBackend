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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('contact')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role');
            $table->string('photo')->nullable();
            $table->string('address')->nullable();
            $table->string('officialID')->nullable();
            $table->string('designation')->nullable();
            $table->string('officeLocation')->nullable();
            $table->string('department')->nullable();
            $table->string('education')->nullable();
            $table->string('pan')->nullable();
            $table->string('aadhar')->nullable();
            $table->string('passbook')->nullable();
            $table->string('offerLetter')->nullable();
            $table->string('PFNO')->nullable();
            $table->string('ESINO')->nullable();
            $table->string('joiningDate')->nullable();
            $table->string('leavingDate')->nullable();
            $table->string('jobStatus')->nullable();
            $table->string('about')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
