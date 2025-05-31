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
        Schema::create('pengiriman_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('masyarakat_id')->constrained()->onDelete('cascade');
            $table->enum('tipe', ['sholat', 'hadist']);
            $table->string('waktu')->nullable(); // ex: subuh, dzuhur (hanya untuk sholat)
            $table->text('pesan');
            $table->timestamp('dikirim_pada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman_logs');
    }
};
