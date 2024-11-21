@extends('pemilik.layout.template')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Hama Berdasarkan Kelembaban dan Suhu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Replace Roboto with Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif; /* Updated to Poppins */
        }
        .container {
            max-width: 1400px;  /* Memperbesar container utama */
            margin-top: 30px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }
        .card-body {
            padding: 30px;
        }
        .card-title {
            font-size: 1.75rem;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-title img {
            height: 150px;
            margin-top: -70px;
        }
        .icon {
            font-size: 4rem;
            color: #007bff;
        }
        .text-primary {
            color: #012970 !important;
        }
        .mt-4 {
            margin-top: 1.5rem !important;
        }
        .lead {
            font-size: 1.5rem;
        }
        .data-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            font-size: 1.5rem; /* Increased font size */
        }
        .data-item {
            text-align: center;
            flex: 1;
        }
        .data-item h5 {
            margin-bottom: 10px;
            font-size: 2rem; /* Increased heading font size */
        }
        .data-item p {
            font-size: 1.5rem; /* Increased paragraph font size */
        }
        .text-center {
            font-size: 1.5rem;
        }
        .spinner {
            font-size: 3rem; /* Increase spinner icon size */
            color: #007bff;
            animation: spin 2s linear infinite;
        }
        .weather-info {
            font-size: 2rem; /* Increase text size for weather info */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes logo-animation {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="mb-4 text-primary">Selamat Datang di Sistem Deteksi Hama</h1>
                <p class="lead">Membantu petani mengidentifikasi hama berdasarkan kelembaban dan suhu.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">
                            <img src="{{asset('img')}}/semut.gif" height="150px" style="margin-top: -70px;">
                            Deteksi Hama Berdasarkan Kelembaban dan Suhu
                        </h5>
                        <div class="text-center mt-4 weather-info">
                            <p><img src="{{asset('img')}}/cuaca.png" height="70px" style="margin-top: -10px;">Cuaca di Bandung, Coblong saat ini: </p>
                        </div>
                        <div id="dataDisplay" class="data-container">
                            <!-- Data akan ditampilkan di sini -->
                        </div>
                        <div id="result" class="mt-4">
                            <h4> Hama yang mungkin muncul:</h4>
                            <!-- Hasil deteksi hama akan ditampilkan di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchWeatherData() {
                $.ajax({
                    url: 'https://api.openweathermap.org/data/2.5/weather?lat=-6.8817373&lon=107.6175917&appid=8b994b2ded6267719bd5abaabc048876&units=metric',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const temperature = data.main.temp;
                        const humidity = data.main.humidity;
                        
                        $('#dataDisplay').html(`
                            <div class="data-item">
                                <h5>Suhu Saat Ini</h5>
                                <p>${temperature.toFixed(1)} °C</p>
                            </div>
                            <div class="data-item">
                                <h5>Kelembaban Saat Ini</h5>
                                <p>${humidity.toFixed(1)} %</p>
                        `);

                        $('#result').html('<h4>Hama yang mungkin muncul:</h4>' + detectPests(humidity, temperature));
                    },
                    error: function() {
                        $('#dataDisplay').html('<p>Error fetching data. Please try again later.</p>');
                    }
                });
            }

            function detectPests(humidity, temperature) {
                let pests = '';
                if (humidity < 50 && temperature > 15) {
                    pests = `
                        <ul>
                            <li><i class="fas fa-spider"></i> Hama Penggerek Batang Padi</li>
                            <li><i class="fas fa-bug"color:green></i> Belalang Kembara</li>
                            <li><i class="fas fa-bug"></i> Thrips pada Cabai</li>
                            <li><i class="fas fa-bug"style='color:red'></i> Ulat Grayak</li>
                        </ul>`;
                } else if (humidity >= 50 && humidity < 70 && temperature <= 25) {
                    pests = `
                        <ul>
                            <li><i class="fas fa-cloud-rain"></i> Penyakit Blast</li>
                            <li><i class="fas fa-bug"></i> Wereng</li>
                            <li><i class="fas fa-mouse"></i> Tikus</li>
                            <li><i class="fas fa-leaf"></i> Sundep</li>
                            <li><i class="fas fa-seedling"></i> Hawar Daun Bakteri</li>
                            <li><i class="fas fa-bug"></i> Ulat Tanah</li>
                        </ul>`;
                } else if (humidity >= 70 && temperature <= 28) {
                    pests = `
                        <ul>
                            <li><i class="fas fa-spider"></i> Jamur Karat Daun</li>
                            <li><i class="fas fa-spider"></i> Hama Penggerek Batang Padi</li>
                            <li><i class="fas fa-caterpillar"></i> Ulat Penggerek Buah</li>
                        </ul>`;
                } else {
                    pests = `
                        <ul>
                            <li>Data tidak mencukupi untuk mendeteksi hama spesifik. Silakan periksa kembali nilai kelembaban dan suhu.</li>
                        </ul>`;
                }
                return pests;
            }

            // Initialize with default data
            fetchWeatherData();

            // Auto-refresh data every 30 seconds
            setInterval(fetchWeatherData, 10000); 
        });
    </script>
</body>
</html>

@endsection
