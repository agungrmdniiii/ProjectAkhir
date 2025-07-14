@extends('home.v_template')

@section('content')
    <div class="landing-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 hero-text text-center">
                        <h1 class="display-4 mb-3">Selamat Datang di <span class="text-primary">HAMAXPERT</span></h1>
                        <p class="lead mb-4">Sistem Monitoring dan Pengendalian Hama Tanaman Padi</p>
                        
                    </div>
                    <div class="col-lg-6 hero-image">
                        <img src="{{asset('img')}}/wheat.png" alt="Tanaman Padi" class="img-fluid animated">
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">
            <!-- Bagian 1: Tentang Padi -->
            <div class="row section mb-5">
                <div class="col-md-6">
                    <img src="{{asset('img')}}/rice.png" height="400px" style="margin-left: 100px"  class="rice-image" alt="Tanaman Padi">
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body"> 
                            <h2 class="card-title section-title">Mengenal Tanaman Padi</h2>
                            <div class="card-text">
                                <p class="text-justify">
                                    Padi (Oryza sativa) merupakan tanaman pangan utama di Indonesia yang menjadi sumber makanan pokok sebagian besar penduduk. 
                                    Tanaman padi dapat tumbuh di sawah dengan ketinggian 0-1.500 meter di atas permukaan laut dengan suhu optimal 24-29°C.
                                </p>
                                <p class="text-justify">
                                    Keistimewaan padi terletak pada perannya dalam menjaga ketahanan pangan nasional, di mana setiap butir padi mengandung kekayaan gizi, protein, mineral, dan karbohidrat yang menjadi sumber energi utama bagi lebih dari 270 juta penduduk. Keberagaman varietas padi, mulai dari padi sawah hingga padi gogo, menunjukkan kekayaan genetik dan adaptasi budidaya yang luar biasa, sekaligus menjadi pilar penopang kesejahteraan jutaan petani di seluruh Indonesia.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Hama Padi -->
            <div class="row section mb-5">
                <div class="col-md-12">
                    <h2 class="section-title text-center mb-4">Hama Utama Tanaman Padi</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title" onclick="showModal('{{asset('img')}}/wereng.jpg', 'Wereng Coklat')">Wereng Coklat</h5>
                                    <p class="card-text">Hama yang menghisap cairan tanaman padi dan dapat menyebabkan penyakit virus kerdil.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title" onclick="showModal('{{asset('img')}}/penggerek.jpg', 'Penggerek Batang')">Penggerek Batang</h5>
                                    <p class="card-text">Menyerang batang padi dan menyebabkan gagal pembentukan malai.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title" onclick="showModal('{{asset('img')}}/walangsangit.jpg', 'Walang Sangit')">Walang Sangit</h5>
                                    <p class="card-text">Menghisap bulir padi yang sedang mengisi dan menyebabkan bulir hampa.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Pentingnya Pengendalian -->
            <div class="row section mb-5">
                <div class="col-md-12">
                    <h2 class="section-title text-center">Pentingnya Pengendalian Hama Padi</h2>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="feature-box text-center">
                                <i class="fas fa-chart-line fa-3x mb-3 text-primary"></i>
                                <h4>Produktivitas</h4>
                                <p>Meningkatkan hasil panen hingga 40% dengan pengendalian hama yang tepat</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-box text-center">
                                <i class="fas fa-leaf fa-3x mb-3 text-primary"></i>
                                <h4>Kualitas</h4>
                                <p>Menjaga kualitas beras yang dihasilkan tetap optimal</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-box text-center">
                                <i class="fas fa-dollar-sign fa-3x mb-3 text-primary"></i>
                                <h4>Ekonomi</h4>
                                <p>Mengurangi kerugian ekonomi akibat serangan hama</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Gambar Hama" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <style>
        .landing-container {
            background-color: #ffffff;
        }
        .hero-section {
            padding: 100px 0;
            background-color: #ffffff;
            margin-bottom: 50px;
        }
        
        .hero-text {
            padding-right: 30px;
        }
        
        .hero-text h1 {
            font-size: 3.2rem;
            font-weight: 700;
            line-height: 1.2;
            color: #2d2d2d;
        }
        
        .hero-text .lead {
            font-size: 1.25rem;
            color: #666;
            margin-bottom: 30px;
        }
        
        .hero-buttons {
            margin-top: 30px;
        }
        
        .hero-image {
            text-align: center;
        }
        
        .hero-image img.animated {
            animation: float 6s ease-in-out infinite;
            max-height: 450px;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        
        @media (max-width: 991.98px) {
            .hero-text {
                text-align: center;
                padding-right: 0;
                margin-bottom: 40px;
            }
            
            .hero-text h1 {
                font-size: 2.5rem;
            }
            
            .hero-image img.animated {
                max-height: 350px;
            }
        }
        .section {
            padding: 40px 0;
        }
        .section-title {
            color: #012970;
            margin-bottom: 20px;
        }
        .feature-box {
            padding: 20px;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        .card {
            transition: transform 0.3s;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .text-primary {
            color: #012970 !important;
        }
        .text-justify {
            text-align: justify;
        }
        .rice-image {
            margin-top: 10px;
            transition: transform 0.5s ease;
            max-width: 100%;
            
        }
        
        .rice-image:hover {
            transform: scale(1.1) rotate(2deg);
        }
        .card-title {
            cursor: pointer;
            color: #012970;
            transition: color 0.3s;
        }
        
        .card-title:hover {
            color: #0d6efd;
        }

        #modalImage {
            max-height: 70vh;
            width: auto;
        }

        .modal-content {
            background-color: white;
            border-radius: 10px;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
            background-color: #f8f9fa;
            border-radius: 10px 10px 0 0;
        }
    </style>

    <script>
    function showModal(imageUrl, title) {
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        document.getElementById('modalImage').src = imageUrl;
        document.getElementById('imageModalLabel').textContent = title;
        modal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const titles = document.querySelectorAll('.card-title');
        titles.forEach(title => {
            title.style.cursor = 'pointer';
        });
    });
    </script>
@endsection
