@extends('home.v_template')

@section('content')
<div class="container">
    <h1>Daftar Pengajuan Hama</h1>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('pengajuanhama.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pengajuan Hama
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Hama</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th>Waktu Pelaporan</th>
                    <th>Suhu</th>
                    <th>Kelembaban</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuanHama as $hama)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $hama->jenis_hama }}</td>
                        <td>{{ $hama->lokasi }}</td>
                        <td>{{ $hama->keterangan }}</td>
                        <td>{{ $hama->waktu_pelaporan }}</td>
                        <td>{{ $hama->suhu }}°C</td>
                        <td>{{ $hama->kelembaban }}%</td>
                        <td>
                            <form action="{{ route('pengajuanhama.destroy', $hama->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data pengajuan hama</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection