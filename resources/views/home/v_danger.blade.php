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
    <style>
        /* Custom styles here */
    </style>
</head>
<body class="custom-content">
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
                            <p><img src="{{asset('img')}}/cuaca.png" height="70px" style="margin-top: -10px;">Cuaca di Bandung, Coblong saat ini: </p>
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

                        const pests = detectPests(humidity, temperature);
                        $('#result').html('<h4>Hama yang mungkin muncul:</h4>' + pests.names);
                        $('#handling').html('<h4>Saran Penanganan:</h4>' + pests.handling);
                    },
                    error: function() {
                        $('#dataDisplay').html('<p>Error fetching data. Please try again later.</p>');
                    }
                });
            }

            function detectPests(humidity, temperature) {
                let names = '';
                let handling = '';
                
                if (humidity >= 70 && temperature >= 26 && temperature <= 30) {
                    names += `<ul><li><i class="fas fa-bug"></i> Wereng Batang Coklat</li></ul>`;
                    handling += `
                        <ul>
                            <li>Penggunaan Varietas Tahan: Pilih varietas padi yang tahan terhadap wereng.</li>
                            <li>Pengelolaan Air: Kurangi genangan air di sawah.</li>
                            <li>Aplikasi Insektisida: Gunakan insektisida yang efektif pada tahap nymph.</li>
                        </ul>`;
                }
                if (humidity >= 70 && temperature >= 25 && temperature <= 28) {
                    names += `<ul><li><i class="fas fa-bug"></i> Penggerek Batang Padi</li></ul>`;
                    handling += `
                        <ul>
                            <li>Rotasi Tanaman: Hindari penanaman padi berturut-turut.</li>
                            <li>Penggunaan Feromon: Pasang perangkap feromon.</li>
                            <li>Penggunaan Insektisida: Aplikasikan insektisida pada tahap awal.</li>
                        </ul>`;
                }
                if (humidity >= 60 && temperature >= 22 && temperature <= 30) {
                    names += `<ul><li><i class="fas fa-mouse"></i> Tikus Sawah</li></ul>`;
                    handling += `
                        <ul>
                            <li>Pengendalian Fisik: Pasang perangkap tikus di sawah.</li>
                            <li>Pengendalian Biologis: Manfaatkan predator alami.</li>
                            <li>Penggunaan Rodentisida: Gunakan rodentisida dengan hati-hati.</li>
                        </ul>`;
                }
                if (humidity >= 30 && humidity <= 70 && temperature >= 28 && temperature <= 35) {
                    names += `<ul><li><i class="fas fa-bug"></i> Belalang</li></ul>`;
                    handling += `
                        <ul>
                            <li>Penggunaan Insektisida: Semprotkan insektisida saat populasi belalang meningkat.</li>
                            <li>Pengelolaan Lahan: Lakukan pengolahan lahan secara rutin.</li>
                            <li>Pemantauan Populasi: Lakukan pemantauan rutin.</li>
                        </ul>`;
                }
                if (humidity >= 70 && temperature >= 25 && temperature <= 30) {
                    names += `<ul><li><i class="fas fa-bug"></i> Kepik Hijau</li></ul>`;
                    handling += `
                        <ul>
                            <li>Aplikasi Insektisida: Gunakan insektisida pada fase perkembangan telur dan nymph.</li>
                            <li>Pengelolaan Air: Hindari genangan air berlebih.</li>
                            <li>Pemantauan: Lakukan pemantauan rutin.</li>
                        </ul>`;
                }
                
                return { names, handling };
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
