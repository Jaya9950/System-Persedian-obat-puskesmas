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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->nullOnDelete();
            $table->string('nama_obat');
            $table->string('sku')->unique()->comment('SKU (Stock Keeping Unit) / Kode Obat');
            $table->string('sat');
            $table->integer('stok_awal');
            $table->integer('penerimaan');
            $table->integer('persediaan');
            $table->integer('pemakaian')->default(0);
            $table->integer('sisa_stok');
            $table->integer('permintaan');
            $table->integer('pemberian');
            $table->string('ket');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
