@extends('home.v_template')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Edit Data Pertanian</h1>

    <!-- Form untuk mengedit data -->
    <form action="{{ route('data.update', $dataPertanian->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="jumlah_pestisida">Jumlah Pestisida Dipakai (liter)</label>
            <input type="number" name="jumlah_pestisida" id="jumlah_pestisida" class="form-control" value="{{ $dataPertanian->jumlah_pestisida }}" required>
        </div>

        <div class="form-group">
            <label for="lama_panen">Lama Panen (hari)</label>
            <input type="number" name="lama_panen" id="lama_panen" class="form-control" value="{{ $dataPertanian->lama_panen }}" required>
        </div>

        <div class="form-group">
            <label for="hasil_panen">Hasil Panen (kg)</label>
            <input type="number" name="hasil_panen" id="hasil_panen" class="form-control" value="{{ $dataPertanian->hasil_panen }}" required>
        </div>

        <div class="form-group">
            <label for="luas_lahan">Luas Lahan (m²)</label>
            <input type="number" name="luas_lahan" id="luas_lahan" class="form-control" value="{{ $dataPertanian->luas_lahan }}" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Update Data</button>
    </form>
</div>
@endsection
