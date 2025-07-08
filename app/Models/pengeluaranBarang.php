<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranBarang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function nomorPengeluaran()
    {
        $max = self::max('id');
        $prefix = 'PBR-';
        $date = date('dmy');
        $nomor = $prefix . $date . str_pad($max + 1, 4, '0', STR_PAD_LEFT);
        return $nomor;
    }

    public function items()
    {
        return $this->hasMany(ItemPengeluaranBarang::class, 'pengeluaran_barang_id', 'id');
    }
}