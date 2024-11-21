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