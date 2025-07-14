@extends('home.v_template')

@section('content')
    <div class="container">
        <h1>Daftar Pengajuan Barang</h1>

        <!-- Tampilkan pesan sukses -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif


        <!-- Tabel untuk menampilkan data pengajuan barang -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengajuanBarang as $barang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->jumlah }}</td>
                        <td>{{ $barang->keterangan }}</td>
                        <td>
                            <!-- Tombol setujui -->
                            <form action="{{ route('pengajuanbarang.setujui', $barang->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-success">Setujui</button>
                            </form>

                            <!-- Tombol hapus -->
                            <form action="{{ route('pengajuanbarang.destroy', $barang->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            <a href="{{ route('pengajuanbarang.create') }}" class="btn btn-primary ">Tambah Pengajuan Barang</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
