@extends('pemilik.layout.template')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Kondisi Tanah</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
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
        .chart-container {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            background-color: #ffffff;
            margin-top: 20px;
            height: 500px;
        }
        .chart-container canvas {
            width: 100% !important;
            height: 100% !important;
        }
        .dropdown, .btn {
            margin: 10px 0;
        }
        .chart-header {
            margin-bottom: 15px;
            font-size: 1.25rem;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="mb-4">Monitoring Kondisi Tanah</h1>
                <p class="lead">Pilih data yang ingin Anda tampilkan di grafik dengan mengklik kotak data.</p>
            </div>
        </div>
        <div class="row justify-content-center">
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
        
        <!-- Dropdown untuk memilih jangka waktu -->
        <div class="row mt-4 justify-content-center">
            <div class="col-md-4">
                <select id="timePeriodDropdown" class="form-control">
                    <option value="week">1 Minggu Terakhir</option>
                    <option value="month">3 Bulan Terakhir</option>
                    <option value="year">3 Tahun Terakhir</option>
                </select>
            </div>
        </div>

        <!-- Grafik tunggal -->
        <div class="row">
            <div class="col-md-12">
                <div class="chart-container">
                    <div class="chart-header" id="chartTitle">1 Minggu Terakhir</div>
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>

        <div class="row mt-4 justify-content-center">
            <div class="col-md-4 text-center">
                <button class="btn btn-success" id="exportBtn">Export ke Excel</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        let selectedData = {};
        let myChart = null;

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

        $('#timePeriodDropdown').change(function() {
            const selectedPeriod = $(this).val();
            updateChart(selectedPeriod);
            updateChartTitle(selectedPeriod);
        });

        function updateChart(period = 'week') {
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
                        borderWidth: 1,
                        fill: false
                    });
                }
            }

            const ctx = document.getElementById('chart').getContext('2d');
            if (myChart) {
                myChart.destroy();
            }
            myChart = new Chart(ctx, {
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
                    }
                }
            });
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
                    months.unshift(date.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' }));
                }
                return months;
            } else if (period === 'year') {
                return Array.from({ length: 3 }, (_, i) => (now.getFullYear() - 2 + i).toString());
            }
        }

        function generateDataForPeriod(dataType, period) {
            const data = {
                'nitrogen': {
                    'week': Array.from({ length: 7 }, () => 30 + Math.random() * 10),
                    'month': Array.from({ length: 3 }, () => 25 + Math.random() * 10),
                    'year': Array.from({ length: 3 }, () => 20 + Math.random() * 5)
                },
                'phosphorus': {
                    'week': Array.from({ length: 7 }, () => 15 + Math.random() * 5),
                    'month': Array.from({ length: 3 }, () => 18 + Math.random() * 7),
                    'year': Array.from({ length: 3 }, () => 20 + Math.random() * 10)
                },
                'potassium': {
                    'week': Array.from({ length: 7 }, () => 40 + Math.random() * 10),
                    'month': Array.from({ length: 3 }, () => 35 + Math.random() * 10),
                    'year': Array.from({ length: 3 }, () => 30 + Math.random() * 10)
                },
                'soilTemp': {
                    'week': Array.from({ length: 7 }, () => 25 + Math.random() * 3),
                    'month': Array.from({ length: 3 }, () => 24 + Math.random() * 2),
                    'year': Array.from({ length: 3 }, () => 23 + Math.random() * 2)
                },
                'soilMoisture': {
                    'week': Array.from({ length: 7 }, () => 40 + Math.random() * 5),
                    'month': Array.from({ length: 3 }, () => 42 + Math.random() * 5),
                    'year': Array.from({ length: 3 }, () => 45 + Math.random() * 5)
                }
            };
            return data[dataType][period];
        }

        function getLabelForDataType(type) {
            const labels = {
                'nitrogen': 'Nitrogen',
                'phosphorus': 'Fosfor',
                'potassium': 'Kalium',
                'soilTemp': 'Suhu Tanah',
                'soilMoisture': 'Kelembaban Tanah'
            };
            return labels[type];
        }

        function getColorForDataType(type, part) {
            const colors = {
                'nitrogen': {
                    'background': 'rgba(0, 123, 255, 0.2)',
                    'border': 'rgba(0, 123, 255, 1)'
                },
                'phosphorus': {
                    'background': 'rgba(40, 167, 69, 0.2)',
                    'border': 'rgba(40, 167, 69, 1)'
                },
                'potassium': {
                    'background': 'rgba(255, 193, 7, 0.2)',
                    'border': 'rgba(255, 193, 7, 1)'
                },
                'soilTemp': {
                    'background': 'rgba(220, 53, 69, 0.2)',
                    'border': 'rgba(220, 53, 69, 1)'
                },
                'soilMoisture': {
                    'background': 'rgba(23, 162, 184, 0.2)',
                    'border': 'rgba(23, 162, 184, 1)'
                }
            };
            return colors[type][part];
        }

        function updateChartTitle(period) {
            const titles = {
                'week': '1 Minggu Terakhir',
                'month': '3 Bulan Terakhir',
                'year': '3 Tahun Terakhir'
            };
            $('#chartTitle').text(titles[period]);
        }

        $(document).ready(function() {
            updateChart();
        });
    </script>
</body>
</html>
@endsection
