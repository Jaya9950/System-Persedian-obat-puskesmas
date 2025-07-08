<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $guarded = ["id"];

    public function kurangiStok($qty)
    {
        $this->stok_awal -= $qty;
        $this->persediaan -= $qty;
        $this->pemakaian += $qty;
        $this->sisa_stok -= $qty;
        $this->save();
    }

    protected $fillable = [
        'sku',
        'nama_obat',
        'sat',
        'stok_awal',
        'kategori_id',
        'penerimaan',
        'persediaan',
        'pemakaian',
        'sisa_stok',
        'permintaan',
        'pemberian',
        'ket',
        'is_active'
    ];

    public static function nomorSku()
    {
        // SKU-00001
        $prefix = 'SKU-';
        $maxId = self::max('id');
        $sku = $prefix . str_pad($maxId + 1, 5, '0'. STR_PAD_LEFT);
        return $sku;
    }
}
