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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('employment_type')->comment('fulltime, partime,...');
            $table->string('position')->comment('staff, manager, ceo,...');
            $table->string('salary');
            $table->string('deadline');
            $table->string('description');
            $table->string('requirement');
            $table->string('benefit');
            $table->string('location');
            $table->string('workplace');
            $table->string('working_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
