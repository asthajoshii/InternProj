<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('schoolcode');
            $table->string('erpid');
            $table->string('rollno');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('class');
            $table->string('div');
            $table->date('dob')->nullable();
            $table->string('bloodgroup')->nullable();
            $table->string('pname');
            $table->string('pcontact');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('landmark')->nullable();
            $table->string('pincode');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
