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
        Schema::create('m_opsi_jawaban', function (Blueprint $table) {
            $table->id();
            $table->integer('soal_id');
            $table->string('opsi_jawaban');
            $table->boolean('is_jawaban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_opsi_jawaban');
    }
};
