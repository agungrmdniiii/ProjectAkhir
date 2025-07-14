@extends('pemilik.layout.template')

@section('content')
<div class="container">
    <h1>Pengajuan Hama</h1>

    <form action="{{ route('pengajuanhama.store') }}" method="POST" id="pengajuanForm">
        @csrf
        <div class="form-group">
            <label for="jenis_hama">Jenis Hama</label>
            <select name="jenis_hama" class="form-control" id="jenis_hama" required>
                <option value="">Pilih Jenis Hama</option>
                @foreach($hamaList as $hama)
                    <option value="{{ $hama->id }}">{{ $hama->nama_hama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="lokasi">Lokasi</label>
            <input type="text" name="lokasi" class="form-control" id="lokasi" required 
                   placeholder="Masukkan lokasi ditemukannya hama">
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" class="form-control" 
                      placeholder="Deskripsikan kondisi hama yang ditemukan"></textarea>
        </div>

        <!-- Hidden inputs untuk menyimpan data cuaca dan koordinat -->
        <input type="hidden" name="suhu" id="suhu">
        <input type="hidden" name="kelembaban" id="kelembaban">
        <input type="hidden" name="koordinat_lat" id="koordinat_lat">
        <input type="hidden" name="koordinat_lon" id="koordinat_lon">

        <div class="center-button">
            <button type="button" id="detectLocationBtn" class="btn btn-primary">Deteksi Lokasi Otomatis</button>
            <button type="button" id="openMapBtn" class="btn btn-primary">Pilih di Peta</button>
        </div>

        <div id="map-container" style="display: none;">
            <div class="text-right mb-2">
                <button id="closeMapBtn" class="btn btn-danger btn-sm">
                    <i class="fas fa-times"></i> Tutup Peta
                </button>
            </div>
            <div id="map" style="height: 400px;"></div>
        </div>

        <div id="dataDisplay" class="data-container">
            <!-- Data cuaca akan ditampilkan di sini -->
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-success">Simpan Pengajuan</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    $(document).ready(function() {
        let lat = -6.2088; // Default latitude (Bandung)
        let lon = 106.8456; // Default longitude (Bandung)
        let map = null;
        let marker = null;

        // Cek localStorage untuk koordinat yang tersimpan
        if (localStorage.getItem('latitude') && localStorage.getItem('longitude')) {
            lat = parseFloat(localStorage.getItem('latitude'));
            lon = parseFloat(localStorage.getItem('longitude'));
        }

        function fetchWeatherData() {
            $.ajax({
                url: `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=8b994b2ded6267719bd5abaabc048876&units=metric`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    const temperature = data.main.temp;
                    const humidity = data.main.humidity;

                    // Update hidden inputs
                    $('#suhu').val(temperature);
                    $('#kelembaban').val(humidity);

                    // Update display
                    $('#dataDisplay').html(`
                        <div class="data-item">
                            <h5>Suhu Saat Ini</h5>
                            <p>${temperature.toFixed(1)} °C</p>
                        </div>
                        <div class="data-item">
                            <h5>Kelembaban Saat Ini</h5>
                            <p>${humidity.toFixed(1)} %</p>
                        </div>
                    `);
                },
                error: function(error) {
                    console.error('Error fetching weather data:', error);
                    $('#dataDisplay').html('<p>Error mengambil data cuaca. Silakan coba lagi nanti.</p>');
                }
            });
        }

        // Fungsi untuk mendapatkan lokasi saat ini
        $('#detectLocationBtn').on('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    lat = position.coords.latitude;
                    lon = position.coords.longitude;
                    localStorage.setItem('latitude', lat);
                    localStorage.setItem('longitude', lon);
                    
                    // Update hidden inputs
                    $('#koordinat_lat').val(lat);
                    $('#koordinat_lon').val(lon);
                    
                    // Reverse geocoding untuk mendapatkan alamat
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                        .then(response => response.json())
                        .then(data => {
                            $('#lokasi').val(data.display_name);
                        });
                    
                    fetchWeatherData();
                });
            }
        });

        // Inisialisasi dengan data yang tersimpan atau default
        fetchWeatherData();
    });
</script>
@endsection