@extends('home.v_template')

@section('content')
    <div class="container">
        <h1>Tambah Pengajuan Barang</h1>

        <form action="{{ route('pengajuanbarang.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_barang">Pilih Barang</label>
                <select name="nama_barang" class="form-control" required>
                    <option value="">-- Pilih Barang --</option>
                    <option value="Cangkul">Cangkul</option>
                    <option value="Ani-ani">Ani-ani</option>
                    <option value="Gerejag">Gerejag</option>
                    <option value="Tongkat Tunggal">Tongkat Tunggal</option>
                    <option value="Penggaris Sawah">Penggaris Sawah</option>
                    <option value="Gosrok">Gosrok</option>
                </select>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea name="keterangan" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Tambah</button>
        </form>
    </div>
@endsection
