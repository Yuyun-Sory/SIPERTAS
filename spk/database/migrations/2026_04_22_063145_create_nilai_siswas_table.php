<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel ini menyimpan nilai setiap siswa pada setiap sub-kriteria
     * untuk periode tertentu. Nilai berupa integer 1–4.
     */
    public function up(): void
    {
        Schema::create('nilai_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')
                  ->constrained('siswas')
                  ->onDelete('cascade');
            $table->foreignId('sub_kriteria_id')
                  ->constrained('sub_kriterias')
                  ->onDelete('cascade');
            $table->foreignId('periode_id')
                  ->constrained('periodes')
                  ->onDelete('cascade');
            $table->unsignedTinyInteger('nilai')->default(1)->comment('Nilai 1-4');
            $table->timestamps();

            // Satu siswa hanya punya 1 nilai per sub-kriteria per periode
            $table->unique(['siswa_id', 'sub_kriteria_id', 'periode_id'], 'unique_nilai_siswa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_siswas');
    }
};