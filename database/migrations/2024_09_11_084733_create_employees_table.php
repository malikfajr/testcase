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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('picture');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->boolean('gender')->comment('0 = male, 1 = female');
            $table->date('date_of_birth');
            $table->date('hire_date');
            $table->date('end_date');
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->integer('salary', 11)->autoIncrement(false);
            $table->boolean('status')->comment('0 = inactive, 1 = active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
