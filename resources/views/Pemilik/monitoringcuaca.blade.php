@extends('pemilik.layout.template')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Kondisi Cuaca</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .data-box {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #ffffff;
            margin-bottom: 30px;
            transition: background-color 0.3s, border-color 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 180px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .data-box.selected {
            border-color: #012970;
            background-color: #eaf4ff;
        }
        .data-box i {
            font-size: 40px;
            margin-bottom: 10px;
            color: #012970;
        }
        .data-box h5 {
            margin: 10px 0;
            font-size: 1.2rem;
        }
        .data-box p {
            font-size: 1.1rem;
            color: #333;
        }
        .chart-container {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background-color: #ffffff;
            margin-bottom: 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .chart-container canvas {
            width: 100% !important;
            height: 500px !important;
        }
        .chart-header {
            margin-bottom: 20px;
            font-size: 1.8rem;
            text-align: center;
            font-weight: bold;
            color: #012970;
        }
        .btn {
            margin-top: 20px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center mb-4">
                <h1>Monitoring Kondisi Cuaca</h1>
                <p class="lead">Pilih data yang ingin Anda tampilkan di grafik dengan mengklik kotak data.</p>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-3">
                <div id="tempBox" class="data-box" data-type="temperature">
                    <i class="fas fa-thermometer-half"></i>
                    <h5>Suhu</h5>
                    <p id="tempValue">Loading...</p>
                </div>
            </div>
            <div class="col-md-3">
                <div id="humidityBox" class="data-box" data-type="humidity">
                    <i class="fas fa-tint"></i>
                    <h5>Kelembaban</h5>
                    <p id="humidityValue">Loading...</p>
                </div>
            </div>
            <div class="col-md-3">
                <div id="rainBox" class="data-box" data-type="rainfall">
                    <i class="fas fa-cloud-rain"></i>
                    <h5>Curah Hujan</h5>
                    <p id="rainValue">Loading...</p>
                </div>
            </div>
            <div class="col-md-3">
                <div id="solarBox" class="data-box" data-type="solar">
                    <i class="fas fa-sun"></i>
                    <h5>Radiasi Matahari</h5>
                    <p id="solarValue">Loading...</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <select id="timePeriod" class="form-control">
                    <option value="week">1 Minggu Terakhir</option>
                    <option value="month">3 Bulan Terakhir</option>
                    <option value="year">3 Tahun Terakhir</option>
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="chart-container">
                    <div class="chart-header">Monitoring Data</div>
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row mt-4 justify-content-center">
            <div class="col-md-4 text-center">
                <button class="btn btn-primary" id="exportBtn">Export History</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let selectedData = {};
        let mainChart = null;

        $(document).ready(function() {
            fetchWeatherData();
            updateChart();
        });

        $('.data-box').click(function() {
            const dataType = $(this).data('type');
            $(this).toggleClass('selected');

            if ($(this).hasClass('selected')) {
                selectedData[dataType] = true;
            } else {
                delete selectedData[dataType];
            }

            updateChart();
        });

        $('#timePeriod').change(function() {
            updateChart();
        });

        function updateChart() {
            const period = $('#timePeriod').val();
            const labels = getLabelsForPeriod(period);
            const chartData = {
                labels: labels,
                datasets: []
            };

            for (const [type, isSelected] of Object.entries(selectedData)) {
                if (isSelected) {
                    chartData.datasets.push({
                        label: getLabelForDataType(type),
                        data: generateDataForPeriod(type, period),
                        backgroundColor: getColorForDataType(type, 'background'),
                        borderColor: getColorForDataType(type, 'border'),
                        borderWidth: 2,
                        fill: false
                    });
                }
            }

            const ctx = document.getElementById('mainChart').getContext('2d');
            if (mainChart) {
                mainChart.data = chartData; // Update the chart data
                mainChart.update(); // Update the chart display
            } else {
                mainChart = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Waktu'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Nilai'
                                },
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw.toFixed(2);
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        function getLabelsForPeriod(period) {
            const now = new Date();
            if (period === 'week') {
                return Array.from({ length: 7 }, (_, i) => {
                    const date = new Date();
                    date.setDate(now.getDate() - (6 - i));
                    return date.toLocaleDateString('id-ID');
                });
            } else if (period === 'month') {
                const months = [];
                for (let i = 0; i < 3; i++) {
                    const date = new Date();
                    date.setMonth(now.getMonth() - i);
                    months.unshift(date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' }));
                }
                return months;
            } else if (period === 'year') {
                return Array.from({ length: 3 }, (_, i) => {
                    const date = new Date();
                    date.setFullYear(now.getFullYear() - i);
                    return date.getFullYear();
                }).reverse();
            }
            return [];
        }

        function generateDataForPeriod(type, period) {
            if (period === 'week') {
                return Array.from({ length: 7 }, () => getRandomValueForType(type));
            } else if (period === 'month') {
                return Array.from({ length: 3 }, () => getRandomValueForType(type));
            } else if (period === 'year') {
                return Array.from({ length: 3 }, () => getRandomValueForType(type));
            }
            return [];
        }

        function getRandomValueForType(type) {
            switch (type) {
                case 'temperature':
                    return Math.random() * 15 + 15; // Example: temperature between 15 and 30
                case 'humidity':
                    return Math.random() * 30 + 50; // Example: humidity between 50 and 80
                case 'rainfall':
                    return Math.random() * 20; // Example: rainfall between 0 and 20mm
                case 'solar':
                    return Math.random() * 1000; // Example: solar radiation between 0 and 1000 W/m²
                default:
                    return 0;
            }
        }

        function getLabelForDataType(type) {
            switch (type) {
                case 'temperature':
                    return 'Suhu';
                case 'humidity':
                    return 'Kelembaban';
                case 'rainfall':
                    return 'Curah Hujan';
                case 'solar':
                    return 'Radiasi Matahari';
                default:
                    return '';
            }
        }

        function getColorForDataType(type, colorType) {
            const colors = {
                temperature: { background: 'rgba(255, 99, 132, 0.2)', border: 'rgba(255, 99, 132, 1)' },
                humidity: { background: 'rgba(54, 162, 235, 0.2)', border: 'rgba(54, 162, 235, 1)' },
                rainfall: { background: 'rgba(75, 192, 192, 0.2)', border: 'rgba(75, 192, 192, 1)' },
                solar: { background: 'rgba(255, 206, 86, 0.2)', border: 'rgba(255, 206, 86, 1)' }
            };
            return colors[type] ? colors[type][colorType] : '#000';
        }

        async function fetchWeatherData() {
            const apiUrl = 'https://api.openweathermap.org/data/2.5/weather?lat=-6.8817373&lon=107.6175917&appid=8b994b2ded6267719bd5abaabc048876&units=metric';
            
            try {
                const response = await fetch(apiUrl);
                const data = await response.json();

                const temperature = data.main.temp;
                const humidity = data.main.humidity;
                const rain = data.rain ? data.rain['1h'] : 0; // Curah hujan dalam 1 jam, default 0 jika tidak ada
                const solarRadiation = data.clouds.all; // Menggunakan data persentase awan sebagai perkiraan radiasi matahari

                document.getElementById('tempValue').innerText = `${temperature}°C`;
                document.getElementById('humidityValue').innerText = `${humidity}%`;
                document.getElementById('rainValue').innerText = `${rain} mm`;
                document.getElementById('solarValue').innerText = `${solarRadiation} W/m²`;

                updateChart();
            } catch (error) {
                console.error("Error fetching weather data:", error);
            }
        }

        $('#exportBtn').click(function() {
            const data = [
                ['Tanggal', 'Suhu', 'Kelembaban', 'Curah Hujan', 'Radiasi Matahari'],
                ...getLabelsForPeriod($('#timePeriod').val()).map((label, index) => [
                    label,
                    selectedData.temperature ? generateDataForPeriod('temperature', $('#timePeriod').val())[index] : '',
                    selectedData.humidity ? generateDataForPeriod('humidity', $('#timePeriod').val())[index] : '',
                    selectedData.rainfall ? generateDataForPeriod('rainfall', $('#timePeriod').val())[index] : '',
                    selectedData.solar ? generateDataForPeriod('solar', $('#timePeriod').val())[index] : ''
                ])
            ];

            const worksheet = XLSX.utils.aoa_to_sheet(data);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Data Cuaca");

            XLSX.writeFile(workbook, `data_cuaca_${$('#timePeriod').val()}.xlsx`);
        });
    </script>
</body>
</html>
@endsection
