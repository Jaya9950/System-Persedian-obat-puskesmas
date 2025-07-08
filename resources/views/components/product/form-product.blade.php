<div>
    <button type="button" class="btn {{ $id ? 'btn-warning' : 'btn-primary' }}" data-toggle="modal" data-target="#formProduct{{ $id ?? '' }}">
        @if ($id)
          <i class="fas fa-edit"></i>
          @else
          product baru
        @endif
    </button>
    <div class="modal fade" id="formProduct{{ $id ?? '' }}">
        <form action="{{ route('data-obat.product.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $id ?? '' }}">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{ $id ? 'Form Edit Product' : 'Form Product Baru' }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group my-1">
                <label for="">Nama Obat</label>
                <input type="text" name="nama_obat" id="nama_obat" class="form-control" 
                    value="{{ $id ? ($nama_obat ?? '') : old('nama_obat') }}">
              </div>
              <div class="form-group my-1">
                <label for="">Kategori Product</label>
                <select name="kategori_id" id="kategori_id" class="form-control">
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" {{ (old('kategori_id', $kategori_id ?? '') == $item->id) ? 'selected' : '' }}>
                            {{ $item->nama_kategori }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group my-1">
                <label for="">SAT</label>
                <input type="text" name="sat" id="sat" class="form-control" value="{{ $id ? 
                    $sat : old('sat') }}">
              </div>
              <div class="form-group my-1">
                <label for="">Stok Awal</label>
                <input type="number" name="stok_awal" id="stok_awal" class="form-control" value="{{ $id ? 
                    $stok_awal : old('stok_awal') }}">
              </div>
              <div class="form-group my-1">
                <label for="">Penerimaan</label>
                <input type="number" name="penerimaan" id="penerimaan" class="form-control" value="{{ $id ? 
                    $penerimaan : old('penerimaan') }}">
              </div>
              <div class="form-group my-1">
                <label for="">Persediaan</label>
                <input type="number" name="persediaan" id="persediaan" class="form-control" value="{{ $id ? 
                    $persediaan : old('persediaan') }}">
              </div>
              <div class="form-group my-1">
                <label for="">Pemakaian</label>
                <input type="number" name="pemakaian" id="pemakaian" class="form-control" value="{{ $id ? 
                    $pemakaian : old('pemakaian') }}">
              </div>
              <div class="form-group my-1">
                <label for="">Sisa Stok</label>
                <input type="number" name="sisa_stok" id="sisa_stok" class="form-control" value="{{ $id ? 
                    $sisa_stok : old('sisa_stok') }}">
              </div>
              <div class="form-group my-1">
                <label for="">Permintaan</label>
                <input type="number" name="permintaan" id="permintaan" class="form-control" value="{{ $id ? 
                    $permintaan : old('permintaan') }}">
              </div>
              <div class="form-group my-1">
                <label for="">Pemberian</label>
                <input type="number" name="pemberian" id="pemberian" class="form-control" value="{{ $id ? 
                    $pemberian : old('pemberian') }}">
              </div>
              <div class="form-group my-1">
                <label for="">Ket</label>
                <input type="text" name="ket" id="ket" class="form-control" value="{{ $id ? 
                    $ket : old('ket') }}">
              </div>
              <div class="form-group my-1 flex-column">
                <div class="d-flex align-items-center">
                    <label for="" class="mr-4">Produk Aktif ?</label>
                    <input type="checkbox" name="is_active" id="is_active"
                        {{ old('is_active', $id ? $is_active :false) ? 'checked' : ''}}
                    >
                </div>
                <small class="text-secondary -mt-2">Jika aktif maka product akan ditampilkan di halaman awal</small>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        </form>
      </div>
      <!-- /.modal -->
</div>