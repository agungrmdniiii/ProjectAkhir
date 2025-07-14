@extends('home.v_template')

@section('content')

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Deteksi Hama Berdasarkan Kelembaban dan Suhu</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <style>
            .pest-detection-page body {
                font-family: 'Poppins', sans-serif;
            }

            .pest-detection-page .custom-content {
                background-color: #f8f9fa;
            }

            .pest-detection-page .card {
                border-radius: 15px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .pest-detection-page .card-title {
                color: #333;
                font-weight: 700;
            }

            .pest-detection-page .data-container {
                display: flex;
                justify-content: space-around;
                margin-top: 20px;
            }

            .pest-detection-page .data-item {
                text-align: center;
                padding: 10px;
            }

            .pest-detection-page .data-item h5 {
                color: #495057;
                font-size: 1rem;
            }

            .pest-detection-page .data-item p {
                color: #007bff;
                font-size: 1.5rem;
                font-weight: 700;
                margin-bottom: 0;
            }

            #coordinateForm {
                display: none;
                margin-top: 10px;
            }

            .center-button,
            .center-form {
                text-align: center;
                margin-bottom: 15px;
            }

            .center-form form {
                display: inline-block;
                text-align: left;
            }

            .center-form .form-row {
                justify-content: center;
            }

            #result ul, #handling ul {
                list-style-type: none;
                padding-left: 0;
            }
            
            #result li, #handling li {
                margin-bottom: 10px;
                padding: 8px;
                background-color: #f8f9fa;
                border-radius: 5px;
            }
            
            #result li i {
                margin-right: 8px;
                color: #dc3545;
            }
            
            .data-item {
                background-color: white;
                padding: 15px;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
            .data-item h5 {
                color: #6c757d;
                margin-bottom: 10px;
            }
            
            .data-item p {
                font-size: 24px;
                font-weight: bold;
                color: #007bff;
                margin: 0;
            }
            
            #map-container {
                margin: 20px 0;
                border-radius: 10px;
                overflow: hidden;
            }
            
            #map {
                border-radius: 10px;
            }
        </style>
    </head>

    <body class="custom-content pest-detection-page">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                <img src="{{asset('img')}}/semut.gif" height="150px" style="margin-top: -70px;">
                                Deteksi Hama Berdasarkan Kelembaban dan Suhu
                            </h5>
                            <div class="text-center mt-4 weather-info">
                                <p><img src="{{asset('img')}}/cuaca.png" height="70px" style="margin-top: -10px;">Cuaca saat
                                    ini di <span id="locationName">Bandung</span> </p>
                            </div>
                            <div class="center-button">
                                <button id="openMapBtn" class="btn btn-primary btn-sm">
                                    <i class="fas fa-map-marker-alt"></i> Ganti Lokasi
                                </button>
                            </div>
                            <div id="map-container" style="display: none;">
                                <div class="text-right mb-2">
                                    <button id="closeMapBtn" class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i> Tutup Peta
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <button id="detectLocationBtn" class="btn btn-success btn-sm">
                                        <i class="fas fa-location-arrow"></i> Deteksi Lokasi Otomatis
                                    </button>
                                </div>
                                <div id="map" style="height: 400px;"></div>
                            </div>
                            <div id="dataDisplay" class="data-container">
                                <!-- Data akan ditampilkan di sini -->
                            </div>
                            <div id="result" class="mt-4">
                                <h4> Hama yang mungkin muncul:</h4>
                                <!-- Hasil deteksi hama akan ditampilkan di sini -->
                            </div>
                            <div id="handling" class="mt-4">
                                <h4> Saran Penanganan:</h4>
                                <!-- Saran penanganan hama akan ditampilkan di sini -->
                            </div>

                            <!-- Tambahkan bagian persebaran hama -->
                            <div class="mt-4">
                                <h4>Persebaran Hama:</h4>
                                <div id="persebaran-map" style="height: 400px; border-radius: 10px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                let lat = -6.2088; // Default latitude (Bandung)
                let lon = 106.8456; // Default longitude (Bandung)
                let map = null;
                let marker = null;

                // Cek localStorage untuk koordinat yang tersimpan
                if (localStorage.getItem('latitude') && localStorage.getItem('longitude')) {
                    lat = parseFloat(localStorage.getItem('latitude'));
                    lon = parseFloat(localStorage.getItem('longitude'));
                }

                function fetchLocationName(lat, lon) {
                    $.ajax({
                        url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            let locationName = data.address.city || data.address.town || data.address.village || data.address.hamlet || data.address.suburb || data.display_name.split(',')[0];
                            $('#locationName').text(locationName);
                        },
                        error: function () {
                            $('#locationName').text('Lokasi tidak diketahui');
                        }
                    });
                }

                function fetchWeatherData() {
                    $.ajax({
                        url: `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=8b994b2ded6267719bd5abaabc048876&units=metric`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            const temperature = data.main.temp;
                            const humidity = data.main.humidity;

                            // Simpan data ke database
                            $.ajax({
                                url: '/save-weather-data',
                                type: 'POST',
                                data: {
                                    temperature: temperature,
                                    humidity: humidity,
                                    rainfall: 0, // Sesuaikan dengan data yang tersedia
                                    solar_radiation: 0, // Sesuaikan dengan data yang tersedia
                                    latitude: lat,
                                    longitude: lon,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    console.log('Data cuaca berhasil disimpan');
                                },
                                error: function(error) {
                                    console.error('Error menyimpan data cuaca:', error);
                                }
                            });

                            // Update tampilan
                            $('#tempValue').text(temperature.toFixed(1) + '°C');
                            $('#humidityValue').text(humidity + '%');

                            fetchLocationName(lat, lon);

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

                            const pests = detectPests(humidity, temperature);
                            $('#result').html('<h4>Hama yang mungkin muncul:</h4>' + pests.names);
                            $('#handling').html('<h4>Saran Penanganan:</h4>' + pests.handling);
                        },
                        error: function (error) {
                            console.error('Error fetching weather data:', error);
                            $('#dataDisplay').html('<p>Error mengambil data cuaca. Silakan coba lagi nanti.</p>');
                        }
                    });
                }

                function detectPests(humidity, temperature) {
                    let names = '<ul>';
                    let handling = '<ul>';
                    let pestFound = false;
                    
                    $.ajax({
                        url: '/get-hama-data',
                        type: 'GET',
                        async: false,
                        success: function(data) {
                            data.forEach(function(hama) {
                                if (humidity >= parseFloat(hama.min_humidity) && 
                                    humidity <= parseFloat(hama.max_humidity) && 
                                    temperature >= parseFloat(hama.min_temperature) && 
                                    temperature <= parseFloat(hama.max_temperature)) {
                                    
                                    pestFound = true;
                                    names += `<li><i class="${hama.icon}"></i> ${hama.nama_hama}</li>`;
                                    
                                    // Parse rekomendasi jika dalam format JSON string
                                    let rekomendasi = hama.rekomendasi;
                                    if (typeof rekomendasi === 'string') {
                                        try {
                                            rekomendasi = JSON.parse(rekomendasi);
                                        } catch (e) {
                                            console.error('Error parsing rekomendasi:', e);
                                            rekomendasi = [rekomendasi];
                                        }
                                    }
                                    
                                    // Pastikan rekomendasi adalah array
                                    if (!Array.isArray(rekomendasi)) {
                                        rekomendasi = [rekomendasi];
                                    }
                                    
                                    // Tambahkan setiap rekomendasi ke daftar
                                    rekomendasi.forEach(function(item) {
                                        if (item) {
                                            handling += `<li>${item}</li>`;
                                        }
                                    });
                                }
                            });
                        },
                        error: function(error) {
                            console.error('Error fetching hama data:', error);
                            names = '<ul><li>Error mengambil data hama</li></ul>';
                            handling = '<ul><li>Error mengambil data rekomendasi</li></ul>';
                        }
                    });

                    names += '</ul>';
                    handling += '</ul>';

                    if (!pestFound) {
                        names = '<ul><li>Tidak terdeteksi hama</li></ul>';
                        handling = '<ul><li>Tidak ada rekomendasi penanganan</li></ul>';
                    }

                    return { names, handling };
                }

                $('#openMapBtn').on('click', function () {
                    $('#map-container').show();
                    if (!map) {
                        map = L.map('map').setView([lat, lon], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(map);
                        marker = L.marker([lat, lon]).addTo(map);

                        map.on('click', function (e) {
                            const newLat = e.latlng.lat;
                            const newLon = e.latlng.lng;

                            $.ajax({
                                url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${newLat}&lon=${newLon}&zoom=18&addressdetails=1`,
                                type: 'GET',
                                dataType: 'json',
                                success: function (data) {
                                    const locationName = data.display_name;
                                    if (confirm(`Apakah Anda yakin ingin memilih lokasi ini?\n\nLokasi: ${locationName}`)) {
                                        lat = newLat;
                                        lon = newLon;
                                        localStorage.setItem('latitude', lat);
                                        localStorage.setItem('longitude', lon);
                                        marker.setLatLng([lat, lon]);
                                        fetchWeatherData();
                                        $('#map-container').hide();
                                    }
                                },
                                error: function () {
                                    if (confirm('Apakah Anda yakin ingin memilih lokasi ini?')) {
                                        lat = newLat;
                                        lon = newLon;
                                        localStorage.setItem('latitude', lat);
                                        localStorage.setItem('longitude', lon);
                                        marker.setLatLng([lat, lon]);
                                        fetchWeatherData();
                                        $('#map-container').hide();
                                    }
                                }
                            });
                        });
                    } else {
                        map.setView([lat, lon], 13);
                        marker.setLatLng([lat, lon]);
                    }

                    setTimeout(function () {
                        map.invalidateSize();
                    }, 100);
                });

                $('#detectLocationBtn').on('click', function () {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function (position) {
                            lat = position.coords.latitude;
                            lon = position.coords.longitude;
                            localStorage.setItem('latitude', lat);
                            localStorage.setItem('longitude', lon);
                            
                            // Update marker position
                            if (marker) {
                                marker.setLatLng([lat, lon]);
                            }
                            
                            // Update map view
                            map.setView([lat, lon], 13);
                            
                            // Fetch location name and weather data
                            fetchLocationName(lat, lon);
                            fetchWeatherData();
                            
                            // Close map container
                            $('#map-container').hide();
                        }, function () {
                            alert('Tidak dapat mendeteksi lokasi. Silakan pilih lokasi di peta.');
                        });
                    } else {
                        alert('Geolocation tidak didukung oleh browser Anda. Silakan pilih lokasi di peta.');
                    }
                });

                $('#closeMapBtn').on('click', function () {
                    $('#map-container').hide();
                });

                // Initialize with saved or default data
                fetchWeatherData();

                // Auto-refresh data every 30 seconds
                setInterval(fetchWeatherData, 30000);

                // Inisialisasi peta persebaran hama
                const persebaranMap = L.map('persebaran-map').setView([-2.5489, 118.0149], 5);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(persebaranMap);

                // Ambil data persebaran hama
                $.ajax({
                    url: '/get-persebaran-hama',
                    type: 'GET',
                    success: function(data) {
                        // Kelompokkan data berdasarkan jenis hama
                        const hamaGroups = {};
                        data.forEach(item => {
                            if (!hamaGroups[item.jenis_hama]) {
                                hamaGroups[item.jenis_hama] = [];
                            }
                            hamaGroups[item.jenis_hama].push(item);
                        });

                        // Buat marker untuk setiap jenis hama
                        Object.keys(hamaGroups).forEach(jenisHama => {
                            const markers = hamaGroups[jenisHama].map(item => {
                                const popupContent = `
                                    <div>
                                        <h6>${item.jenis_hama}</h6>
                                        <p><strong>Lokasi:</strong> ${item.lokasi}</p>
                                        <p><strong>Waktu:</strong> ${item.waktu_pelaporan}</p>
                                        <p><strong>Suhu:</strong> ${item.suhu}°C</p>
                                        <p><strong>Kelembaban:</strong> ${item.kelembaban}%</p>
                                        <p><strong>Keterangan:</strong> ${item.keterangan}</p>
                                    </div>
                                `;
                                
                                return L.marker([item.koordinat_lat, item.koordinat_lon])
                                    .bindPopup(popupContent);
                            });

                            // Tambahkan layer group ke peta
                            const group = L.layerGroup(markers).addTo(persebaranMap);
                            
                            // Tambahkan ke control layer
                            L.control.layers(null, {
                                [jenisHama]: group
                            }).addTo(persebaranMap);
                        });
                    },
                    error: function(error) {
                        console.error('Error:', error);
                        $('#persebaran-map').html('<p class="text-danger">Gagal memuat data persebaran hama</p>');
                    }
                });
            });
        </script>
    </body>

    </html>

@endsection