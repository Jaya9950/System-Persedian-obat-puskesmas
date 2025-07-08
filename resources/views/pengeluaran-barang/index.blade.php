@extends('layouts.app')
@section('content_title', 'Pengeluaran Barang')
@section('content')
<div class="card">
    <form action="{{ route('pengeluaran-barang.store') }}" method="POST" id="form-pengeluaran_barang">
        @csrf
        <div id="data-hidden"></div>

        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
            <h4 class="h5">Pengeluaran Barang</h4>
        </div>

        <div class="card-body">
            <div class="d-flex mb-3">
                <div class="flex-grow-1 me-2">
                    <label for="select2">Pilih Obat:</label>
                    <select name="select2" id="select2" class="form-control"></select>
                </div>
                <div class="me-2" style="width: 150px">
                    <label for="current_stok_awal">Stok Tersedia:</label>
                    <input type="number" id="current_stok_awal" class="form-control" readonly>
                </div>
                <div class="me-2" style="width: 120px">
                    <label for="qty">Qty:</label>
                    <input type="number" id="qty" class="form-control" min="1">
                </div>
                <div class="me-2">
                    <label class="d-block">&nbsp;</label>
                    <button type="button" class="btn btn-dark" id="btn-add">Tambahkan</button>
                </div>
            </div>

            <div class="row">
                <!-- Tabel Produk -->
                <div class="col-md-7">
                    <div class="card h-100">
                        <div class="card-body">
                            <table class="table table-sm" id="table-produk">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Qty</th>
                                        <th>Sat</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Input Total -->
                <div class="col-md-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-2">
                                <label for="keluar">Barang Keluar</label>
                                <input type="number" class="form-control" id="keluar" name="keluar" readonly>
                            </div>
                            <div class="mb-2">
                                <label for="sat_display">Jenis Barang</label>
                                <input type="text" class="form-control" id="sat_display" readonly>
                            </div>
                            <div class="mb-2">
                                <label for="jumlah">Jumlah Barang</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" min="1">
                            </div>
                            <div class="mb-2">
                                <label for="permintaan" class="form-label">Permintaan Dari</label>
                                <input type="text" class="form-control" id="permintaan" name="permintaan" placeholder="Permintaan dari siapa">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function () {
        let selectedProduk = {};

        function hitungTotal() {
            let total = 0;
            let firstRowSat = '-';

            $('#table-produk tbody tr').each(function (index) {
                const qty = parseInt($(this).find('td:eq(1)').text()) || 0;
                total += qty;

                if (index === 0) {
                    firstRowSat = $(this).find('td:eq(2)').text();
                }
            });

            $('#jumlah').val(total);
            $('#keluar').val(total);
            $('#sat_display').val(firstRowSat);
        }

        $('#select2').select2({
            theme: 'bootstrap',
            placeholder: 'Cari Produk...',
            ajax: {
                url: "{{ route('get-data.obat') }}",
                dataType: 'json',
                delay: 250,
                data: params => ({ search: params.term }),
                processResults: data => {
                    data.forEach(item => selectedProduk[item.id] = item);
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.nama_obat
                        }))
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#select2").on("change", function () {
            const id = $(this).val();
            $.get("{{ route('get-data.cek-stok-awal') }}", { id }, function (response) {
                $("#current_stok_awal").val(response);
            });
        });

        $("#btn-add").on("click", function () {
            const selectedId = $("#select2").val();
            const qty = $("#qty").val();
            const produk = selectedProduk[selectedId];

            if (!selectedId || !qty) {
                alert("Harap pilih produk dan tentukan jumlah.");
                return;
            }

            let exist = false;
            $('#table-produk tbody tr').each(function () {
                const rowNama = $(this).find("td:eq(0)").text();
                if (rowNama === produk.nama_obat) {
                    let currentQty = parseInt($(this).find("td:eq(1)").text());
                    $(this).find("td:eq(1)").text(currentQty + parseInt(qty));
                    exist = true;
                    return false;
                }
            });

            if (!exist) {
                const row = `
                    <tr data-id="${produk.id}">
                        <td>${produk.nama_obat}</td>
                        <td>${qty}</td>
                        <td>${produk.sat || '-'}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-remove">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                $("#table-produk tbody").append(row);
            }

            $("#select2").val(null).trigger("change");
            $("#qty").val(null);
            $("#current_stok_awal").val(null);

            hitungTotal();
        });

        $("#table-produk").on("click", ".btn-remove", function () {
            $(this).closest('tr').remove();
            hitungTotal();
        });

        $("#form-pengeluaran_barang").on("submit", function () {
            $("#data-hidden").html("");

            $("#table-produk tbody tr").each(function (index, row) {
                const namaObat = $(row).find("td:eq(0)").text();
                const qty = $(row).find("td:eq(1)").text();
                const produkId = $(row).data("id");

                $("#data-hidden").append(`
                    <input type="hidden" name="produk[${index}][qty]" value="${qty}">
                    <input type="hidden" name="produk[${index}][produk_id]" value="${produkId}">
                `);
            });
        });
    });
</script>
@endpush