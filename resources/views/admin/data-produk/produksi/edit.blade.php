<form action="{{ route('admin.produksi.update', $produkBahanItem->id_produk_bahan) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label for="id_bahan{{ $produkBahanItem->id_produk_bahan }}" class="form-label">Bahan</label>
        <select name="id_bahan" id="id_bahan{{ $produkBahanItem->id_produk_bahan }}" class="form-select" required>
            <option value="">-- Pilih Bahan --</option>
            @foreach ($allBahan as $bahan)
                <option value="{{ $bahan->id_bahan }}"
                    @if ($produkBahanItem->id_bahan == $bahan->id_bahan) selected @endif>
                    {{ $bahan->nama_bahan }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="jumlah_bahan{{ $produkBahanItem->id_produk_bahan }}" class="form-label">Jumlah</label>
        <input type="number" name="jumlah_bahan" id="jumlah_bahan{{ $produkBahanItem->id_produk_bahan }}" class="form-control"
            value="{{ $produkBahanItem->jumlah_bahan }}" required min="0">
    </div>

    <div class="mb-3">
        <label for="satuan{{ $produkBahanItem->id_produk_bahan }}" class="form-label">Satuan</label>
        <input type="text" name="satuan" id="satuan{{ $produkBahanItem->id_produk_bahan }}" class="form-control"
            value="{{ $produkBahanItem->satuan }}" required>
    </div>

    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
