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
        Schema::create('m_hasil_tes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('soal_id');
            $table->integer('opsi_jawaban_id')->nullable();
            $table->string('jenis_soal');
            $table->boolean('is_benar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_hasil_tes');
    }
};
