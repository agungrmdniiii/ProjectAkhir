@extends('home.v_template')

@section('content')
    <div class="container">
        <h1>Edit Pengajuan Barang</h1>

        <!-- Form untuk mengedit pengajuan barang -->
        <form action="{{ route('pengajuanbarang.update', $pengajuanBarang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ $pengajuanBarang->nama_barang }}" required>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" value="{{ $pengajuanBarang->jumlah }}" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea name="keterangan" class="form-control">{{ $pengajuanBarang->keterangan }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
