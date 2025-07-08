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
        Schema::create('item_pengeluaran_barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengeluaran_barang_id');
            $table->unsignedBigInteger('product_id');
            $table->string('nama_produk');
            $table->string('sat')->nullable();
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('pengeluaran_barang_id')->references('id')->on('pengeluaran_barangs')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pengeluaran_barangs');
    }
};
