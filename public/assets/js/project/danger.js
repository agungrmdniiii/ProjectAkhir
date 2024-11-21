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
                    </div>
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
