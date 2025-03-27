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
        Schema::table('interviews', function (Blueprint $table) {
            $table->string('passed_mail_status')->after('candidate_mail_status')->default('unsent');
            $table->string('failed_mail_status')->after('passed_mail_status')->default('unsent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn('passed_mail_status');
            $table->dropColumn('failed_mail_status');
        });
    }
};
