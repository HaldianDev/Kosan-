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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penghuni_id')->constrained('penghunis')->cascadeOnDelete();
            $table->string('bulan_tagihan'); // format YYYY-MM
            $table->unsignedBigInteger('jumlah_tagihan');
            $table->enum('status', ['Lunas', 'Belum Lunas'])->default('Belum Lunas');
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();

            $table->unique(['penghuni_id', 'bulan_tagihan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
