<div>
    <!-- Modal -->
    <div class="modal fade" id="modalFormVarian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalFormVarianLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" enctype="multipart/form-data" action="{{ $action }}">
                @csrf
                <input type="hidden" name="produk_id" id="produk_id" value="{{ $produk_id ?? '' }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalFormVarianLabel">Form Varian</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nama_varian" class="form-label">Nama Varian</label>
                            <input type="text" name="nama_varian" id="nama_varian" class="form-control"
                                value="{{ old('nama_varian', $nama_varian ?? '') }}">
                            <small class="text-danger"></small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="rak_id" class="form-label">Lokasi Rak</label>
                            <select name="rak_id" id="rak_id" class="form-control">
                                <option value="">-- Belum Ditentukan --</option>
                                @foreach($raks ?? [] as $rak)
                                    <option value="{{ $rak->id }}" {{ old('rak_id', $rak_id ?? '') == $rak->id ? 'selected' : '' }}>
                                        {{ $rak->zona->gudang->nama_gudang }} &raquo; {{ $rak->zona->nama_zona }} &raquo; {{ $rak->kode_rak }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Posisi fisik barang ini di gudang</small>
                            <small class="text-danger"></small>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="stok_varian" class="form-label">Stok Awal</label>
                                    <input type="number" name="stok_varian" id="stok_varian" class="form-control"
                                        value="{{ old('stok_varian', $stok_varian ?? 0) }}">
                                    <small class="text-muted">Tambah stok lebih lanjut lewat Transaksi Masuk</small>
                                    <small class="text-danger"></small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="berat" class="form-label">Berat</label>
                                    <input type="text" name="berat" id="berat" class="form-control"
                                        placeholder="Contoh: 500gr" value="{{ old('berat', $berat ?? '') }}">
                                    <small class="text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="dimensi" class="form-label">Dimensi</label>
                            <input type="text" name="dimensi" id="dimensi" class="form-control"
                                placeholder="Contoh: 30x20x10cm" value="{{ old('dimensi', $dimensi ?? '') }}">
                            <small class="text-danger"></small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambar_varian" class="form-label">Gambar</label>
                            <input type="file" name="gambar_varian" id="gambar_varian" class="form-control">
                            <small class="text-danger"></small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
