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
        Schema::table('target_programs', function (Blueprint $table) {
            $table->after('k_tw4', function (Blueprint $table) {
                $table->float('r_kinerja')->nullable();
                $table->float('r_k_tw1')->nullable();
                $table->float('r_k_tw2')->nullable();
                $table->float('r_k_tw3')->nullable();
                $table->float('r_k_tw4')->nullable();
            });
        });
        
        Schema::table('target_kegiatans', function (Blueprint $table) {
            $table->after('k_tw4', function (Blueprint $table) {
                $table->float('r_kinerja')->nullable();
                $table->float('r_k_tw1')->nullable();
                $table->float('r_k_tw2')->nullable();
                $table->float('r_k_tw3')->nullable();
                $table->float('r_k_tw4')->nullable();
            });
        });

        Schema::table('target_subkegiatans', function (Blueprint $table) {
            $table->after('a_tw4', function (Blueprint $table) {
                $table->float('r_kinerja')->nullable();
                $table->float('r_k_tw1')->nullable();
                $table->float('r_k_tw2')->nullable();
                $table->float('r_k_tw3')->nullable();
                $table->float('r_k_tw4')->nullable();
                $table->bigInteger('r_anggaran')->nullable();
                $table->bigInteger('r_a_tw1')->nullable();
                $table->bigInteger('r_a_tw2')->nullable();
                $table->bigInteger('r_a_tw3')->nullable();
                $table->bigInteger('r_a_tw4')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('target_programs', function (Blueprint $table) {
            //
        });

        Schema::table('target_kegiatans', function (Blueprint $table) {
            //
        });

        Schema::table('target_subkegiatans', function (Blueprint $table) {
            //
        });
    }
};
