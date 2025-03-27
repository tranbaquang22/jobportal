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
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('candidate_name');
            $table->dropColumn('candidate_email');
            $table->dropColumn('candidate_phone');
            $table->dropColumn('cv_path');
            $table->dropColumn('cover_letter');

            $table->unsignedBigInteger('candidate_id')->after('job_id');
            $table->index('candidate_id');

            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
