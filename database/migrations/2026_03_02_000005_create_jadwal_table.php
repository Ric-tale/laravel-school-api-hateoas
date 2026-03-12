<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('mapel_id')->constrained('mapel')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('guru_id')->constrained('guru')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('hari', ['senin','selasa', 'rabu', 'kamis', 'jumat', 'sabtu']);
            $table->string('jam_pelajaran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
