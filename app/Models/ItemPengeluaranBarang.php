<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPengeluaranBarang extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function pengeluaran()
    {
        return $this->belongsTo(PengeluaranBarang::class, 'pengeluaran_barang_id');
    }
}