@extends('home.v_template')

@section('content')
    <div class="container">
        <h1>Pengajuan Barang</h1>

        <form action="{{ route('pengajuanbarang.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_barang">Pilih Barang</label>
                <select name="nama_barang" class="form-control" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($persediaanBarang as $barang)
                        <option value="{{ $barang->nama_barang }}">
                            {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                        </option>
                    @endforeach
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

            <button type="submit" class="btn btn-success">Ajukan</button>
        </form>
    </div>
@endsection
