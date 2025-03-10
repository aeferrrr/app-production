@extends('layout.layout')
@section('title', 'Bahan')
@section('content')
    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Data Bahan
            </h5>
            @if (session('success'))
                <div class="alert alert-success mx-2">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive text-nowrap">
                <div class="left-header d-flex justify-content-between align-items-center mx-3">
                    <form action="{{ route('admin.bahan.item-bahan') }}" class="d-flex gap-2 p-1" method="get">
                        @csrf
                        <input type="text" name="search" class="form-control w-auto" placeholder="Cari Bahan"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                    </form>
                    <a href="{{ route('admin.bahan.create') }}" class="btn btn-sm btn-primary ms-auto">
                        <i class="bx bx-plus"></i> Tambah Bahan
                    </a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>KODE BAHAN</th>
                            <th>NAMA BAHAN</th>
                            <th>HARGA</th>
                            <th>SATUAN</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bahan as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->kode_bahan }}</td>
                                <td>{{ $item->nama_bahan }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="edit-harga form-control" data-id="{{ $item->id_bahan }}" value="Rp {{ number_format($item->harga_bahan, 0, ',', '.') }}">
                                        <span class="ceklist ms-2 text-success" style="display: none;">✅</span>
                                    </div>
                                </td>
                                <td>{{ $item->satuan }}</td>
                                <td class="gap-2">
                                    <form action="{{ route('admin.bahan.destroy', $item->id_bahan) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn text-danger p-0 border-0 bg-transparent">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.bahan.edit', $item->id_bahan) }}" class="text-primary"><i
                                            class="bx bx-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination mt-3 ms-2">
                    {{ $bahan->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".edit-harga").on("focus", function() {
            let harga = $(this).val();
            $(this).val(harga.replace(/Rp\s?|[,.]/g, "")); // Hapus "Rp" & format angka
        });

        $(".edit-harga").on("blur", function() {
            updateHarga($(this)); // Panggil fungsi update saat kehilangan fokus
        });

        $(".edit-harga").on("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Hindari form submit saat tekan Enter
                $(this).blur(); // Trigger blur untuk menyimpan harga
            }
        });

        function updateHarga(inputHarga) {
            let hargaBaru = inputHarga.val().replace(/\D/g, ""); // Hanya angka
            let idBahan = inputHarga.data("id");
            let ceklist = inputHarga.siblings(".ceklist");

            $.ajax({
                url: "{{ route('admin.bahan.bahan.update-harga') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: idBahan,
                    harga_bahan: hargaBaru
                },
                success: function(response) {
                    let hargaFormatted = formatRupiah(hargaBaru); // Format ulang ke Rp
                    inputHarga.val(hargaFormatted); // Pasang kembali Rp
                    ceklist.fadeIn().delay(1000).fadeOut();
                },
                error: function(xhr) {
                    alert("Gagal memperbarui harga!");
                }
            });
        }

        function formatRupiah(angka) {
            return "Rp " + parseInt(angka).toLocaleString("id-ID"); // Format Rp
        }
    });
</script>
