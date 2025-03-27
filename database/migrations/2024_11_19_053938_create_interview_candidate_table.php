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
        Schema::create('interview_candidate', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interview_id');
            $table->unsignedBigInteger('candidate_id');
            $table->timestamps();

            $table->index('candidate_id');
            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade')->onUpdate('restrict');

            $table->index('interview_id');
            $table->foreign('interview_id')->references('id')->on('interviews')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interview_candidate', function (Blueprint $table) {
            $table->dropForeign(['candidate_id']);
            $table->dropForeign(['interview_id']);
        });

        Schema::dropIfExists('interview_candidate');
    }
};
