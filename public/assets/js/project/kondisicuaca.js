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