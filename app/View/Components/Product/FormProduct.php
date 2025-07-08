<?php

namespace App\View\Components\Product;

use App\Models\Kategori;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormProduct extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $nama_obat, $sat, $stok_awal, $penerimaan, $persediaan, $pemakaian, $sisa_stok, 
    $permintaan, $pemberian, $ket, $is_active, $kategori_id, $kategori;
    public function __construct($id = null)
    {
        $this->kategori = Kategori::all();
        if($id) {
            $product = Product::find($id);
            $this->id           = $product->id;
            $this->nama_obat    = $product->nama_obat;
            $this->sat          = $product->sat;
            $this->stok_awal    = $product->stok_awal;
            $this->penerimaan   = $product->penerimaan;
            $this->persediaan   = $product->persediaan;
            $this->pemakaian    = $product->pemakaian;
            $this->sisa_stok    = $product->sisa_stok;
            $this->pemberian    = $product->pemberian;
            $this->ket          = $product->ket;
            $this->is_active    = $product->is_active;
            $this->kategori_id  = $product->kategori_id;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product.form-product');
    }
}
