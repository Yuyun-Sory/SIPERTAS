<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayats', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['smart', 'ahp', 'nilai']);
            $table->foreignId('periode_id')->nullable()->constrained('periodes')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('judul');
            $table->text('keterangan')->nullable();
            $table->json('siswa_ids')->nullable();  // ID siswa yang dihitung (array)
            $table->json('data_json');              // snapshot hasil perhitungan/input
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayats');
    }
};