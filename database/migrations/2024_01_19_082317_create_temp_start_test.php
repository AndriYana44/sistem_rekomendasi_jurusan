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
        Schema::create('r_start_test', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('jenis_soal');
            $table->date('start_test');
            $table->date('end_test')->nullable();
            $table->boolean('is_submit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_start_test');
    }
};
