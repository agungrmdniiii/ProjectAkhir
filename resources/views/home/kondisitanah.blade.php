@extends('home.v_template')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4 text-center">Input Data Pertanian</h1>
            
            <!-- Form untuk menyimpan data pertanian -->
            <form action="{{ route('data.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="jumlah_pestisida">Jumlah Pestisida Dipakai (liter)</label>
                    <input type="number" name="jumlah_pestisida" id="jumlah_pestisida" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="lama_panen">Lama Panen (hari)</label>
                    <input type="number" name="lama_panen" id="lama_panen" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="hasil_panen">Hasil Panen (kg)</label>
                    <input type="number" name="hasil_panen" id="hasil_panen" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="luas_lahan">Luas Lahan (m2)</label>
                    <input type="number" name="luas_lahan" id="luas_lahan" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Simpan Data</button>
            </form>
        </div>
    </div>
</div>
@endsection
