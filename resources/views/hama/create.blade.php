@extends('home.v_template')

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
                <option value="other">Jenis Hama Lain</option>
            </select>
        </div>

        <!-- Form tambahan untuk jenis hama baru -->
        <div id="newHamaForm" style="display: none;">
            <div class="form-group">
                <label for="nama_hama_baru">Nama Hama Baru</label>
                <input type="text" name="nama_hama_baru" class="form-control" id="nama_hama_baru" 
                       placeholder="Masukkan nama hama baru">
            </div>
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

        <div id="map-container" style="display: none; margin-top: 20px;">
            <div class="text-right mb-2">
                <button type="button" id="closeMapBtn" class="btn btn-danger btn-sm">
                    <i class="fas fa-times"></i> Tutup Peta
                </button>
            </div>
            <div id="map" style="height: 400px; width: 100%; border-radius: 8px;"></div>
        </div>

        <div id="dataDisplay" class="data-container">
            <!-- Data cuaca akan ditampilkan di sini -->
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-success">Simpan Pengajuan</button>
        </div>
    </form>
</div>

<!-- Tambahkan CSS Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<!-- Tambahkan jQuery dan Leaflet JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<style>
    #map {
        z-index: 1;
    }
    .leaflet-container {
        height: 400px;
        width: 100%;
    }
    .data-container {
        margin-top: 20px;
        display: flex;
        justify-content: space-around;
    }
    .data-item {
        text-align: center;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .data-item h5 {
        margin-bottom: 10px;
        color: #495057;
    }
    .data-item p {
        font-size: 1.2em;
        font-weight: bold;
        color: #007bff;
        margin: 0;
    }
    #newHamaForm {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>

<script>
    $(document).ready(function() {
        // Toggle form hama baru
        $('#jenis_hama').on('change', function() {
            if ($(this).val() === 'other') {
                $('#newHamaForm').show();
                $('#nama_hama_baru').prop('required', true);
            } else {
                $('#newHamaForm').hide();
                $('#nama_hama_baru').prop('required', false);
            }
        });

        let lat = -6.2088; // Default latitude (Bandung)
        let lon = 106.8456; // Default longitude (Bandung)
        let map = null;
        let marker = null;

        // Cek localStorage untuk koordinat yang tersimpan
        if (localStorage.getItem('latitude') && localStorage.getItem('longitude')) {
            lat = parseFloat(localStorage.getItem('latitude'));
            lon = parseFloat(localStorage.getItem('longitude'));
        }

        function initMap() {
            if (!map) {
                map = L.map('map').setView([lat, lon], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                
                marker = L.marker([lat, lon]).addTo(map);

                map.on('click', function(e) {
                    const newLat = e.latlng.lat;
                    const newLon = e.latlng.lng;

                    // Update marker position
                    marker.setLatLng([newLat, newLon]);

                    // Update hidden inputs
                    $('#koordinat_lat').val(newLat);
                    $('#koordinat_lon').val(newLon);

                    // Reverse geocoding untuk mendapatkan alamat
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${newLat}&lon=${newLon}`)
                        .then(response => response.json())
                        .then(data => {
                            $('#lokasi').val(data.display_name);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            }
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

        // Event handler untuk tombol "Pilih di Peta"
        $('#openMapBtn').on('click', function() {
            $('#map-container').show();
            setTimeout(function() {
                initMap();
                map.invalidateSize();
            }, 100);
        });

        // Event handler untuk tombol "Tutup Peta"
        $('#closeMapBtn').on('click', function() {
            $('#map-container').hide();
        });

        // Event handler untuk tombol "Deteksi Lokasi Otomatis"
        $('#detectLocationBtn').on('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    lat = position.coords.latitude;
                    lon = position.coords.longitude;
                    
                    // Update hidden inputs
                    $('#koordinat_lat').val(lat);
                    $('#koordinat_lon').val(lon);
                    
                    // Update marker jika peta sudah diinisialisasi
                    if (marker) {
                        marker.setLatLng([lat, lon]);
                        map.setView([lat, lon], 13);
                    }
                    
                    // Reverse geocoding untuk mendapatkan alamat
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                        .then(response => response.json())
                        .then(data => {
                            $('#lokasi').val(data.display_name);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    
                    fetchWeatherData();
                }, function(error) {
                    console.error('Error getting location:', error);
                    alert('Tidak dapat mendeteksi lokasi. Silakan pilih lokasi di peta.');
                });
            } else {
                alert('Geolocation tidak didukung oleh browser Anda. Silakan pilih lokasi di peta.');
            }
        });

        // Inisialisasi dengan data yang tersimpan atau default
        fetchWeatherData();
    });
</script>
@endsection