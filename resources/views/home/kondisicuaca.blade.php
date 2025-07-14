@extends('home.v_template')

@section('content')
<div class="container">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body { background-color: #f0f2f5; font-family: Arial, sans-serif; }
        .data-box {
            border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px;
            text-align: center; cursor: pointer; background-color: #ffffff;
            margin-bottom: 30px; transition: background-color 0.3s, border-color 0.3s;
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; height: 180px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .data-box.selected { border-color: #012970; background-color: #eaf4ff; }
        .data-box i { font-size: 40px; margin-bottom: 10px; color: #012970; }
        .chart-container {
            border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px;
            background-color: #ffffff; margin-bottom: 40px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .chart-container canvas { width: 100% !important; height: 450px !important; }
        .chart-header { margin-bottom: 20px; font-size: 1.5rem; text-align: center; font-weight: bold; color: #012970; }
        .notification {
            position: fixed; top: 20px; right: 20px; background-color: #28a745;
            color: white; padding: 15px; border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 1050;
            opacity: 0; visibility: hidden; transition: opacity 0.5s, visibility 0.5s, transform 0.5s;
            transform: translateY(-20px);
        }
        .notification.show { opacity: 1; visibility: visible; transform: translateY(0); }
    </style>

    <div id="notification" class="notification"></div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center mb-4">
                <h1>Monitoring Kondisi Cuaca</h1>
                <p class="lead" id="location-info">Meminta izin lokasi Anda...</p>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-3">
                <div id="tempBox" class="data-box selected" data-type="temperature">
                    <i class="fas fa-thermometer-half"></i>
                    <h5>Suhu</h5>
                    <p id="tempValue">-</p>
                </div>
            </div>
            <div class="col-md-3">
                <div id="humidityBox" class="data-box" data-type="humidity">
                    <i class="fas fa-tint"></i>
                    <h5>Kelembaban</h5>
                    <p id="humidityValue">-</p>
                </div>
            </div>
            <div class="col-md-3">
                <div id="rainBox" class="data-box" data-type="rainfall">
                    <i class="fas fa-cloud-showers-heavy"></i>
                    <h5>Curah Hujan (1j)</h5>
                    <p id="rainValue">-</p>
                </div>
            </div>
            <div class="col-md-3">
                <div id="solarBox" class="data-box" data-type="solar_radiation">
                    <i class="fas fa-sun"></i>
                    <h5>Radiasi Matahari</h5>
                    <p id="solarValue">-</p>
                </div>
            </div>
        </div>

        <div class="row mb-4 align-items-end">
            <div class="col-md-4">
                <label for="timePeriod">Pilih Tipe & Periode Grafik:</label>
                <select id="timePeriod" class="form-control">
                    <option value="weekly">Mingguan (Garis)</option>
                    <option value="daily">Harian (Batang)</option>
                    <option value="monthly">Bulanan (Garis)</option>
                    <optgroup label="Pilih Tanggal Spesifik (Batang)" id="historical-dates"></optgroup>
                </select>
                
                
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="chart-container">
                    <div class="chart-header" id="chartTitle">Grafik Cuaca</div>
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let mainChart = null;
        let userLat, userLon;
        let activeDatasets = {
            temperature: true, humidity: false, rainfall: false, solar_radiation: false,
        };

        const dataConfig = {
            temperature: { label: 'Suhu', unit: '°C', color: 'rgba(255, 99, 132, 1)' },
            humidity: { label: 'Kelembaban', unit: '%', color: 'rgba(54, 162, 235, 1)' },
            rainfall: { label: 'Curah Hujan', unit: 'mm', color: 'rgba(75, 192, 192, 1)' },
            solar_radiation: { label: 'Radiasi Matahari', unit: 'W/m²', color: 'rgba(255, 206, 86, 1)' }
        };

        function showNotification(message) {
            const notification = $('#notification');
            notification.text(message).addClass('show');
            setTimeout(() => {
                notification.removeClass('show');
            }, 3000);
        }

        function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            userLat = position.coords.latitude;
            userLon = position.coords.longitude;

            // Menampilkan alamat, bukan koordinat
            getAddressFromCoordinates(userLat, userLon);

            fetchCurrentWeather(userLat, userLon);
            fetchChartData();
            loadAvailableDates();
        }, error => {
            $('#location-info').html('Gagal mendapatkan lokasi. Menggunakan lokasi default (Jakarta).<br>Aktifkan izin lokasi di browser Anda untuk data yang akurat.');
            userLat = -6.2088;
            userLon = 106.8456;

            getAddressFromCoordinates(userLat, userLon);

            fetchCurrentWeather(userLat, userLon);
            fetchChartData();
            loadAvailableDates();
        });
    } else {
        $('#location-info').text('Geolocation tidak didukung oleh browser ini.');
    }
}

function getAddressFromCoordinates(lat, lon) {
    const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`;

    fetch(url)
        .then(res => res.json())
        .then(data => {
            const address = data.display_name || `Lat: ${lat.toFixed(4)}, Lon: ${lon.toFixed(4)}`;
            $('#location-info').text(`Lokasi Terdeteksi: ${address}`);
        })
        .catch(err => {
            console.error("Gagal mendapatkan alamat:", err);
            $('#location-info').text(`Lokasi Terdeteksi: Lat: ${lat.toFixed(4)}, Lon: ${lon.toFixed(4)}`);
        });
}


        function loadAvailableDates() {
            $.ajax({
                url: '{{ route("weather.dates") }}',
                type: 'GET',
                success: function(dates) {
                    const dateGroup = $('#historical-dates');
                    dateGroup.empty();
                    dates.forEach(dateStr => {
                        const date = new Date(dateStr);
                        const formattedDate = date.toLocaleDateString('id-ID', {
                            day: 'numeric', month: 'long', year: 'numeric'
                        });
                        dateGroup.append($('<option>', {
                            value: dateStr,
                            text: formattedDate
                        }));
                    });
                },
                error: function(xhr) {
                    console.error('Gagal memuat tanggal historis:', xhr.responseText);
                }
            });
        }

        async function fetchCurrentWeather(lat, lon) {
            const apiKey = '8b994b2ded6267719bd5abaabc048876';
            const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric&lang=id`;
            
            try {
                const response = await fetch(url);
                const data = await response.json();
                const solarRadiationSubstitute = data.clouds.all;
                const weatherData = {
                    temperature: data.main.temp,
                    humidity: data.main.humidity,
                    rainfall: data?.rain?.['1h'] ?? data?.rain?.['3h'] ?? 0,
                    solar_radiation: solarRadiationSubstitute,
                    latitude: lat,
                    longitude: lon
                };

                $('#tempValue').text(`${weatherData.temperature.toFixed(1)} ${dataConfig.temperature.unit}`);
                $('#humidityValue').text(`${weatherData.humidity} ${dataConfig.humidity.unit}`);
                $('#rainValue').text(`${weatherData.rainfall} ${dataConfig.rainfall.unit}`);
                $('#solarValue').text(`${weatherData.solar_radiation} (${dataConfig.solar_radiation.unit} est.)`);

                saveWeatherDataToDB(weatherData);
            } catch (error) {
                console.error("Error fetching current weather:", error);
            }
        }

        function saveWeatherDataToDB(weatherData) {
             $.ajax({
                url: '{{ route("weather.store") }}',
                type: 'POST',
                data: JSON.stringify(weatherData),
                contentType: 'application/json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: response => showNotification(response.message),
                error: xhr => console.error('Save error:', xhr.responseText)
            });
        }

        function fetchChartData() {
            const period = $('#timePeriod').val();
            if (!userLat || !userLon) return;

            $.ajax({
                url: '{{ route("weather.data") }}',
                type: 'GET',
                data: { period: period, latitude: userLat, longitude: userLon },
                success: data => updateChart(data, period),
                error: xhr => console.error('Error fetching chart data:', xhr.responseText)
            });
        }

        function updateChart(data, period) {
    const ctx = document.getElementById('mainChart').getContext('2d');

    let chartType = 'bar';
    let chartTitle = '';
    let chartDatasets = [];
    const isoDate = period.split('T')[0];

    const paramOrder = ['temperature', 'humidity', 'rainfall', 'solar_radiation'];
    const labels = [];
    const values = [];
    const bgColors = [];
    const borderColors = [];

    // Cek apakah format adalah tanggal spesifik
    const isSpecificDate = /^\d{4}-\d{2}-\d{2}$/.test(isoDate);

    if (isSpecificDate) {
        chartType = 'bar';

        const date = new Date(period);
        const formattedDate = date.toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric'
        });

        chartTitle = `Data Cuaca pada ${formattedDate}`;
        data.x_axis_label = "Parameter Cuaca";

        for (const type of paramOrder) {
            if (activeDatasets[type]) {
                labels.push(dataConfig[type].label);
                values.push(data.datasets?.[type]?.[0] ?? 0);
                bgColors.push(dataConfig[type].color.replace('1)', '0.5)'));
                borderColors.push(dataConfig[type].color);
            }
        }

        chartDatasets = [{
            label: `Nilai Parameter`,
            data: values,
            backgroundColor: bgColors,
            borderColor: borderColors,
            borderWidth: 2
        }];

        data.labels = labels;

    } else {
        // Judul dan jenis grafik berdasarkan periode
        if (period === 'daily') {
            chartType = 'bar';
            chartTitle = "Grafik Batang Hari Ini";
        } else if (period === 'weekly') {
            chartType = 'line';
            chartTitle = "Grafik Garis (7 Hari Terakhir)";
        } else if (period === 'monthly') {
            chartType = 'line';
            chartTitle = "Grafik Garis (30 Hari Terakhir)";
        }

        for (const type of paramOrder) {
            if (activeDatasets[type]) {
                chartDatasets.push({
                    label: `${dataConfig[type].label} (${dataConfig[type].unit})`,
                    data: data.datasets[type],
                    borderColor: dataConfig[type].color,
                    backgroundColor: dataConfig[type].color.replace('1)', '0.3)'),
                    borderWidth: 2,
                    tension: 0.3, // Untuk garis halus
                    fill: chartType === 'bar' // untuk grafik batang diisi
                });
            }
        }
    }

    // Hapus chart sebelumnya jika ada
    if (mainChart) mainChart.destroy();

    mainChart = new Chart(ctx, {
        type: chartType,
        data: {
            labels: data.labels,
            datasets: chartDatasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 20,
                        color: '#333',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                title: {
                    display: true,
                    text: chartTitle,
                    font: {
                        size: 18,
                        weight: 'bold'
                    },
                    color: '#012970',
                    padding: {
                        top: 10,
                        bottom: 20
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: data.x_axis_label,
                        font: { size: 14 },
                        color: '#333'
                    },
                    ticks: {
                        font: { size: 12 },
                        color: '#444'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nilai',
                        font: { size: 14 },
                        color: '#333'
                    },
                    ticks: {
                        font: { size: 12 },
                        color: '#444'
                    }
                }
            }
        }
    });
}

        $(document).ready(function() {
            $('.data-box').click(function() {
                const dataType = $(this).data('type');
                $(this).toggleClass('selected');
                activeDatasets[dataType] = $(this).hasClass('selected');
                fetchChartData();
            });

            $('#timePeriod').change(fetchChartData);

            getUserLocation();

            setInterval(() => {
                if(userLat && userLon) fetchCurrentWeather(userLat, userLon);
            }, 1800000);
        });
    </script>

</div>
   

@endsection
