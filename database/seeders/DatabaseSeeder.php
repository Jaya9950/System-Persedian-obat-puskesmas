<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $dini = User::create([
            'name' => 'Dini',
            'email' => 'supervisor@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'supervisor',
        ]);

        $doni = User::create([
            'name' => 'Doni',
            'email' => 'perawat1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'perawat',
        ]);

        $dodi = User::create([
            'name' => 'Dodi',
            'email' => 'perawat2@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'perawat',
        ]);

        Kategori::create([
            'nama_kategori' => 'BPJS',
            'slug' => 'bpjs',
            'deskripsi' => 'Kategori BPJS',
            'user_id' => $doni->id,
        ]);

        Kategori::create([
            'nama_kategori' => 'Umum',
            'slug' => 'umum',
            'deskripsi' => 'Kategori Umum',
            'user_id' => $dodi->id,
        ]);

        Product::create([
            'nama_obat' => 'Paracetamol',
            'user_id' => $doni->id,
            'sat' => 'tablet',
            'stok_awal' => 100,
            'kategori_id' => 1,
            'penerimaan' => 50,
            'persediaan' => 150,
            'pemakaian' => '10 per hari',
            'sisa_stok' => 140,
            'permintaan' => 20,
            'pemberian' => 15,
            'ket' => 'obat sakit kepala',
            'sku' => Product::nomorSku(),
            'is_active' => true,
        ]);

        Product::create([
            'nama_obat' => 'Pramax',
            'user_id' => $dodi->id,
            'sat' => 'tablet',
            'stok_awal' => 200,
            'kategori_id' => 1,
            'penerimaan' => 30,
            'persediaan' => 230,
            'pemakaian' => '5 per hari',
            'sisa_stok' => 225,
            'permintaan' => 10,
            'pemberian' => 8,
            'ket' => 'obat penenang',
            'sku' => Product::nomorSku(),
            'is_active' => true,
        ]);
    }
}