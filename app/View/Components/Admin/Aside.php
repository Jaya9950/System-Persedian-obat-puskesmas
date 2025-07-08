<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Aside extends Component
{
    /**
     * Create a new component instance.
     */
    public $routes;
    public function __construct()
    {
        $this->routes = [
            [
                "label"         => "Dashboard",
                "icon"          => "fas fa-laptop",
                "route_name"    => "dashboard",
                "route_active"  => "dashboard",
                "is_dropdown"   => false
            ],
            [
                "label"         => "Data Users",
                "icon"          => "fas fa-users",
                "route_name"    => "users.index",
                "route_active"  => "user.*",
                "is_dropdown"   => false
            ],
            [
                "label"         => "Data Obat",
                "icon"          => "fas fa-database",
                "route_active"  => "data-obat.*",
                "is_dropdown"   => true,
                "dropdown"      => [ 

                // Untuk Kategori
                [
                    'route_name' => 'data-obat.kategori.index',
                    'route_active' => 'data-obat.kategori.*',
                    'label' => 'Kategori',
                    'icon' => 'fas fa-tags',
                    'is_dropdown' => false,
                ],
                // Untuk Produk
                [
                    'route_name' => 'data-obat.product.index',
                    'route_active' => 'data-obat.product.*',
                    'label' => 'Produk',
                    'icon' => 'fas fa-capsules',
                    'is_dropdown' => false,
                ],
                ]
                ],
            [
                "label"         => "Penerimaan Barang",
                "icon"          => "fas fa-truck-loading",
                "route_name"    => "penerimaan-barang.index",
                "route_active"  => "penerimaan-barang.*",
                "is_dropdown"   => false
            ],
            [
                "label"         => "Pengeluaran Barang",
                "icon"          => "fas fa-store",
                "route_name"    => "pengeluaran-barang.index",
                "route_active"  => "pengeluaran-barang.*",
                "is_dropdown"   => false
            ],
            [
                "label"         => "Laporan",
                "icon"          => "fas fa-file-invoice",
                "route_active"  => "laporan.*",
                "is_dropdown"   => true,
                "dropdown"      => [ 
                    [
                        "label"         => "penerimaan barang",
                        "route_active"  => "laporan.penerimaan-barang.*",
                        "route_name"    => "laporan.penerimaan-barang.laporan",
                    ],
                    [
                        "label"         => "Pengeluaran barang",
                        "route_active"  => "laporan.pengeluaran-barang.*",
                        "route_name"    => "laporan.pengeluaran-barang.laporan",
                    ],
                ]
            ]
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.aside');
    }
}
