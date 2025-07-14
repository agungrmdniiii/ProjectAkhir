@extends('home.v_template')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Data Pertanian</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Jumlah Pestisida</th>
                <th>Lama Panen</th>
                <th>Hasil Panen</th>
                <th>Luas Lahan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataPertanian as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td> <!-- Auto-increment number -->        
                <td>{{ $data->jumlah_pestisida }}</td>
                <td>{{ $data->lama_panen }}</td>
                <td>{{ $data->hasil_panen }}</td>
                <td>{{ $data->luas_lahan }}</td>
                <td>
                    <!-- Tombol edit -->
                    <a href="{{ route('data.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
    
                    <!-- Tombol hapus -->
                    <form action="{{ route('data.destroy', $data->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
    
                    <!-- Tambah tombol -->
                    <a href="{{ url('/inputdata') }}" class="btn btn-primary btn-sm">Tambah</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection
