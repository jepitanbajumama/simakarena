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
        Schema::create('realisasi_subkegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subkegiatan_id')->constrained('subkegiatans')->cascadeOnDelete();
            $table->float('kinerja')->nullable();
            $table->float('k_tw1')->nullable();
            $table->float('k_tw2')->nullable();
            $table->float('k_tw3')->nullable();
            $table->float('k_tw4')->nullable();
            $table->bigInteger('anggaran')->nullable();
            $table->bigInteger('a_tw1')->nullable();
            $table->bigInteger('a_tw2')->nullable();
            $table->bigInteger('a_tw3')->nullable();
            $table->bigInteger('a_tw4')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasi_subkegiatans');
    }
};
