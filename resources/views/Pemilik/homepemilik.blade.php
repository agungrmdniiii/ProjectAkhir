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
                    <p id="tempValue">25°C</p>
                </div>
            </div>
            <div class="col-md-3">
                <div id="humidityBox" class="data-box" data-type="humidity">
                    <i class="fas fa-tint"></i>
                    <h5>Kelembaban</h5>
                    <p id="humidityValue">70%</p>
                </div>
            </div>
            <div class="col-md-3">
                <div id="rainBox" class="data-box" data-type="rainfall">
                    <i class="fas fa-cloud-rain"></i>
                    <h5>Curah Hujan</h5>
                    <p id="rainValue">100 mm</p>
                </div>
            </div>
            <div class="col-md-3">
                <div id="solarBox" class="data-box" data-type="solar">
                    <i class="fas fa-sun"></i>
                    <h5>Radiasi Matahari</h5>
                    <p id="solarValue">600 W/m²</p>
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
            if (type === 'temperature') {
                return Math.random() * (31 - 17) + 17;
            } else if (type === 'humidity') {
                return Math.random() * (70 - 40) + 40;
            } else if (type === 'rainfall') {
                return Math.random() * 200;
            } else if (type === 'solar') {
                return Math.random() * 1000;
            }
            return 0;
        }

        function getLabelForDataType(type) {
            if (type === 'temperature') {
                return 'Suhu (°C)';
            } else if (type === 'humidity') {
                return 'Kelembaban (%)';
            } else if (type === 'rainfall') {
                return 'Curah Hujan (mm)';
            } else if (type === 'solar') {
                return 'Radiasi Matahari (W/m²)';
            }
            return '';
        }

        function getColorForDataType(type, colorType) {
            const colors = {
                temperature: { background: 'rgba(255, 99, 132, 0.2)', border: 'rgba(255, 99, 132, 1)' },
                humidity: { background: 'rgba(54, 162, 235, 0.2)', border: 'rgba(54, 162, 235, 1)' },
                rainfall: { background: 'rgba(75, 192, 192, 0.2)', border: 'rgba(75, 192, 192, 1)' },
                solar: { background: 'rgba(255, 206, 86, 0.2)', border: 'rgba(255, 206, 86, 1)' }
            };
            return colors[type][colorType];
        }

        $('#exportBtn').click(function() {
    // Prepare data for export
    const period = $('#timePeriod').val();
    const labels = getLabelsForPeriod(period);
    const exportData = [];

    for (const [type, isSelected] of Object.entries(selectedData)) {
        if (isSelected) {
            exportData.push({
                label: getLabelForDataType(type),
                data: generateDataForPeriod(type, period)
            });
        }
    }

    // Create a workbook and add the data
    const wb = XLSX.utils.book_new();
    const ws_data = [];

    // Add header
    const header = ['Waktu'];
    exportData.forEach(item => header.push(item.label));
    ws_data.push(header);

    // Add data rows
    labels.forEach((label, index) => {
        const row = [label];
        exportData.forEach(item => row.push(item.data[index].toFixed(2)));
        ws_data.push(row);
    });

    const ws = XLSX.utils.aoa_to_sheet(ws_data);
    XLSX.utils.book_append_sheet(wb, ws, 'Data Export');

    // Export the workbook
    XLSX.writeFile(wb, 'data_Cuaca.xlsx');
});

$(document).ready(function() {
    updateChart();
});
    </script>
</body>
</html>
@endsection
