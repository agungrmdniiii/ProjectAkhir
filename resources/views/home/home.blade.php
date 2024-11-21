@extends('home.v_template')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Monitoring</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 20px;
        }
        .dashboard-box {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            height: 100%;
        }
        .data-box {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #ffffff;
            margin-bottom: 15px;
            transition: background-color 0.3s, border-color 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 150px;
        }
        .data-box.selected {
            border-color: #012970;
            background-color: #e9f7ff;
        }
        .data-box i {
            font-size: 36px;
            margin-bottom: 10px;
            color: #012970;
        }
        .full-width {
            grid-column: span 3; /* Memperluas ke tiga kolom */
        }
        .text-primary {
            color: #012970 !important;
        }
    </style>
</head>
<body>
    <div class="dashboard-container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="mb-4 text-primary">Selamat Datang di Sistem Smart Nursery</h1>
            </div>
        <div class="dashboard-grid">
            <!-- Container 1 (Top Left) -->
            <div class="dashboard-box">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            <h1>Kondisi Cuaca</h1>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div id="tempBox" class="data-box" data-type="temperature">
                                <i class="fas fa-thermometer-half"></i>
                                <h5>Suhu</h5>
                                <p id="tempValue">25°C</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="humidityBox" class="data-box" data-type="humidity">
                                <i class="fas fa-tint"></i>
                                <h5>Kelembaban</h5>
                                <p id="humidityValue">70%</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="rainBox" class="data-box" data-type="rainfall">
                                <i class="fas fa-cloud-rain"></i>
                                <h5>Curah Hujan</h5>
                                <p id="rainValue">100 mm</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="solarBox" class="data-box" data-type="solar">
                                <i class="fas fa-sun"></i>
                                <h5>Radiasi Matahari</h5>
                                <p id="solarValue">600 W/m²</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container 2 (Top Right) -->
            <div class="dashboard-box">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            <h1>Kondisi Tanah</h1>
                        </div>
                        <div class="col-md-4">
                            <div id="nitrogenBox" class="data-box" data-type="nitrogen">
                                <i class="fas fa-leaf"></i>
                                <h5>Nitrogen</h5>
                                <p>30%</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="phosphorusBox" class="data-box" data-type="phosphorus">
                                <i class="fas fa-flask"></i>
                                <h5>Fosfor</h5>
                                <p>20%</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="potassiumBox" class="data-box" data-type="potassium">
                                <i class="fas fa-bolt"></i>
                                <h5>Kalium</h5>
                                <p>15%</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="soilTempBox" class="data-box" data-type="soilTemp">
                                <i class="fas fa-thermometer-half"></i>
                                <h5>Suhu Tanah</h5>
                                <p>25°C</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="soilMoistureBox" class="data-box" data-type="soilMoisture">
                                <i class="fas fa-tint"></i>
                                <h5>Kelembaban Tanah</h5>
                                <p>40%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container 3: Deteksi Hama Berdasarkan Cuaca -->
            <div class="dashboard-box full-width">
                <div class="container">
                    <div class="card-body">
                        <div class="text-center mt-4 weather-info">
                            <p><img src="{{asset('img')}}/cuaca.png" height="70px" style="margin-top: -10px;">Cuaca di Bandung, Coblong saat ini:</p>
                        </div>
                        <div id="dataDisplay" class="data-container">
                            <!-- Data will be displayed here -->
                        </div>
                        <div id="result" class="mt-4">
                            <h4>Hama yang mungkin muncul:</h4>
                            <!-- Hasil deteksi hama akan ditampilkan di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
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

                        // Update Container 1
                        $('#tempValue').text(`${temperature.toFixed(1)} °C`);
                        $('#humidityValue').text(`${humidity.toFixed(1)} %`);

                        // Update Container 3
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
                            <li><i class="fas fa-bug" color="green"></i> Belalang Kembara</li>
                            <li><i class="fas fa-bug"></i> Thrips pada Cabai</li>
                            <li><i class="fas fa-bug" style="color:red"></i> Ulat Grayak</li>
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

            // Auto-refresh data every 10 seconds
            setInterval(fetchWeatherData, 10000);
        });
    </script>

    <!-- Include JS and libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript to handle data box selection
        document.querySelectorAll('.data-box').forEach(box => {
            box.addEventListener('click', () => {
                document.querySelectorAll('.data-box').forEach(b => b.classList.remove('selected'));
                box.classList.add('selected');
                const type = box.getAttribute('data-type');
                console.log('Selected type:', type);
                // Fetch or update data based on type here
            });
        });
    </script>
</body>
</html>
@endsection
