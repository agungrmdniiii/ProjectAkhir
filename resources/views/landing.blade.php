<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAMAXPERT - Sistem Informasi Prediksi Hama Padi</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS for additional styling and animations -->
    <style>
        /* Menggunakan font Inter sebagai default */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #1ea833; /* Latar belakang gelap utama */
            color: #d1d5db; /* Warna teks default yang lebih lembut */
            overflow-x: hidden;
        }

        /* Styling untuk Hero Section dengan background video */
        #hero-video-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        #hero-video {
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        .hero-section {
            position: relative;
            background-color: rgba(15, 42, 20, 0.8);
        }

        /* Efek Fade di bagian bawah Hero Section */
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 200px; /* Ketinggian area fade */
            background: linear-gradient(to bottom, rgba(17, 24, 39, 0), #111827); /* Gradien dari transparan ke warna bg section bawah */
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2; /* Pastikan konten hero di atas fade */
        }


        /* Efek transisi untuk navbar saat scroll */
        .navbar-scrolled {
            background-color: rgba(12, 20, 39, 0.8);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
        
        /* Gaya untuk gambar fitur yang aktif */
        .feature-image.active {
            opacity: 1;
            transform: scale(1);
        }
        
        .feature-image {
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
            opacity: 0;
            transform: scale(0.95);
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Animasi untuk elemen yang muncul saat di-scroll */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 1s ease-out, transform 0.8s ease-out;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Efek Glassmorphism untuk kartu */
        .glass-card {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: background 0.3s, border 0.3s, transform 0.3s;
        }
        .glass-card:hover {
            background: rgba(51, 65, 85, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: translateY(-8px);
        }

        /* Efek Aurora di Latar Belakang Section */
        .section-bg {
            position: relative;
            background-color: #111827; /* bg-gray-900 */
        }
        .section-bg::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(22, 163, 74, 0.15) 0%, rgba(22, 163, 74, 0) 70%);
            filter: blur(80px);
            z-index: 0;
            animation: float 8s ease-in-out infinite;
        }
        .section-bg::after {
            content: '';
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(234, 179, 8, 0.15) 0%, rgba(234, 179, 8, 0) 70%);
            filter: blur(80px);
            z-index: 0;
            animation: float 10s ease-in-out infinite reverse;
        }
        
        @keyframes float {
            0% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(-20px) translateX(20px); }
            100% { transform: translateY(0px) translateX(0px); }
        }
        
        .content-wrapper {
             position: relative;
             z-index: 1;
        }

    </style>
</head>
<body class="antialiased">

    <!-- Header / Navbar -->
    <header id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo, menggunakan asset Anda -->
                <a href="#" class="flex-shrink-0">
                    <img id="logo" src="{{asset('img')}}/LOGO2.png" alt="Logo HAMAXPERT" class="h-12 transition-all duration-300" onerror="this.onerror=null;this.src='https://placehold.co/180x60?text=Logo';">
                </a>
                <!-- Tombol Masuk (Diperbaiki) -->
                <a href="/login" class="inline-block text-white font-semibold px-6 py-2 rounded-lg shadow-lg bg-gradient-to-r from-green-500 to-amber-500 hover:from-green-600 hover:to-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-green-400 transition-all duration-300 transform hover:scale-105">
                    Masuk ke Sistem
                </a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero-section min-h-screen flex items-center justify-center text-center text-white p-4">
            <div id="hero-video-container">
                <video autoplay loop muted playsinline id="hero-video" poster="{{asset('img')}}/padi.jpg">
                    <!-- Sediakan beberapa format untuk kompatibilitas -->
                    <source src="https://assets.mixkit.co/videos/preview/mixkit-rice-field-in-the-wind-5364-large.mp4" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
            </div>
            <div class="hero-content max-w-4xl reveal visible">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">
                    Selamat Datang di HAMAXPERT
                </h1>
                <p class="text-xl md:text-2xl font-light text-gray-300 mb-8" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.7);">
                    Sistem Cerdas untuk Masa Depan Pertanian Padi Anda
                </p>
                <a href="#fitur" class="bg-amber-500 text-slate-900 font-bold px-8 py-3 rounded-lg shadow-lg hover:bg-amber-400 focus:outline-none focus:ring-4 focus:ring-amber-300 focus:ring-opacity-75 transition-all duration-300 transform hover:scale-105 text-lg">
                    Jelajahi Fitur
                </a>
            </div>
            <!-- Shape Divider Dihapus, digantikan efek fade via CSS -->
        </section>

        <!-- Informasi Tanaman Padi -->
        <section id="tentang-padi" class="py-20 lg:py-24 section-bg">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 content-wrapper">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-24 items-center">
                    <!-- Gambar Padi dari asset Anda -->
                    <div class="reveal">
                        <img src="{{asset('img')}}/padi.jpg" alt="Tanaman Padi" class="rounded-2xl shadow-2xl w-full h-auto object-cover aspect-square" onerror="this.onerror=null;this.src='https://placehold.co/600x600?text=Padi';">
                    </div>
                    <!-- Konten Teks -->
                    <div class="reveal">
                        <h2 class="text-3xl lg:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-green-500 mb-6">Mengenal Tanaman Padi</h2>
                        <p class="text-lg text-gray-400 mb-8 leading-relaxed">
                           Padi (Oryza sativa) adalah tanaman pangan utama di Indonesia. Memahami karakteristiknya adalah kunci untuk melindungi hasil panen dari berbagai ancaman.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-gray-300">
                           <div class="flex items-start"><i class="fa-solid fa-check text-green-400 mt-1 mr-3"></i><span>Batang berongga & kuat</span></div>
                           <div class="flex items-start"><i class="fa-solid fa-check text-green-400 mt-1 mr-3"></i><span>Daun berbentuk pita</span></div>
                           <div class="flex items-start"><i class="fa-solid fa-check text-green-400 mt-1 mr-3"></i><span>Bunga majemuk pada malai</span></div>
                           <div class="flex items-start"><i class="fa-solid fa-check text-green-400 mt-1 mr-3"></i><span>Buah berupa bulir beras</span></div>
                           <div class="flex items-start"><i class="fa-solid fa-check text-green-400 mt-1 mr-3"></i><span>Akar serabut yang kuat</span></div>
                           <div class="flex items-start"><i class="fa-solid fa-check text-green-400 mt-1 mr-3"></i><span>Adaptif di berbagai tanah</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Fase Pertumbuhan Padi -->
        <section id="fase-padi" class="py-20 lg:py-24 bg-gray-900">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 reveal">
                    <h2 class="text-3xl lg:text-4xl font-bold text-white">Fase Pertumbuhan Padi</h2>
                    <p class="mt-4 text-lg text-gray-400 max-w-2xl mx-auto">Setiap fase pertumbuhan padi memiliki kerentanan yang berbeda terhadap serangan hama.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center text-white">
                    <!-- Fase 1: Vegetatif -->
                    <div class="reveal">
                        <div class="bg-white/5 p-6 rounded-full w-32 h-32 mx-auto flex items-center justify-center mb-4 border border-white/10">
                            <i class="fa-solid fa-seedling text-5xl text-green-400"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Vegetatif</h4>
                        <p class="text-gray-400 text-sm">Fase pertumbuhan anakan dan pembentukan daun. Rentan terhadap wereng dan penggerek batang.</p>
                    </div>
                    <!-- Fase 2: Reproduktif -->
                    <div class="reveal" style="transition-delay: 150ms;">
                        <div class="bg-white/5 p-6 rounded-full w-32 h-32 mx-auto flex items-center justify-center mb-4 border border-white/10">
                            <i class="fa-solid fa-spa text-5xl text-green-400"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Reproduktif</h4>
                        <p class="text-gray-400 text-sm">Fase pembentukan malai dan bunga. Rentan terhadap hawar daun dan tungro.</p>
                    </div>
                    <!-- Fase 3: Pemasakan -->
                    <div class="reveal" style="transition-delay: 300ms;">
                        <div class="bg-white/5 p-6 rounded-full w-32 h-32 mx-auto flex items-center justify-center mb-4 border border-white/10">
                             <svg class="w-16 h-16 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Pemasakan</h4>
                        <p class="text-gray-400 text-sm">Pengisian bulir padi. Kualitas dan kuantitas hasil panen ditentukan di fase ini.</p>
                    </div>
                     <!-- Fase 4: Panen -->
                    <div class="reveal" style="transition-delay: 450ms;">
                        <div class="bg-white/5 p-6 rounded-full w-32 h-32 mx-auto flex items-center justify-center mb-4 border border-white/10">
                           <i class="fa-solid fa-wheat-awn text-5xl text-yellow-400"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Panen</h4>
                        <p class="text-gray-400 text-sm">Puncak dari siklus, di mana padi siap untuk dipanen dan diolah menjadi beras.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Informasi Hama Padi -->
        <section id="hama" class="py-20 lg:py-24 section-bg">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 content-wrapper">
                <div class="text-center mb-16 reveal">
                    <h2 class="text-3xl lg:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-yellow-500">Waspadai Hama Utama</h2>
                    <p class="mt-4 text-lg text-gray-400 max-w-2xl mx-auto">Kenali musuh utama tanaman padi Anda untuk tindakan pencegahan yang lebih efektif.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Kartu Hama (Diperbaiki) - Deskripsi selalu terlihat -->
                    <div class="glass-card rounded-2xl flex flex-col reveal">
                        <img src="{{asset('img')}}/wereng.jpg" alt="Wereng Batang Coklat" class="w-full h-56 object-cover rounded-t-2xl" onerror="this.onerror=null;this.src='https://placehold.co/400x300?text=Wereng';">
                        <div class="p-6 flex flex-col flex-grow">
                            <h4 class="text-xl font-bold text-white mb-2">Wereng Batang Coklat</h4>
                            <p class="text-gray-400 text-sm flex-grow">Hama utama yang menyerang tanaman padi dengan menghisap cairan tanaman dan menularkan virus.</p>
                        </div>
                    </div>
                    <div class="glass-card rounded-2xl flex flex-col reveal" style="transition-delay: 150ms;">
                        <img src="{{asset('img')}}/tungro.jpg" alt="Tungro" class="w-full h-56 object-cover rounded-t-2xl" onerror="this.onerror=null;this.src='https://placehold.co/400x300?text=Tungro';">
                         <div class="p-6 flex flex-col flex-grow">
                            <h4 class="text-xl font-bold text-white mb-2">Virus Tungro</h4>
                            <p class="text-gray-400 text-sm flex-grow">Penyakit virus yang ditularkan oleh wereng hijau dan dapat menyebabkan kerusakan parah.</p>
                        </div>
                    </div>
                    <div class="glass-card rounded-2xl flex flex-col reveal" style="transition-delay: 300ms;">
                        <img src="{{asset('img')}}/hawar.jpg" alt="Hawar Daun Bakteri" class="w-full h-56 object-cover rounded-t-2xl" onerror="this.onerror=null;this.src='https://placehold.co/400x300?text=Hawar+Daun';">
                         <div class="p-6 flex flex-col flex-grow">
                            <h4 class="text-xl font-bold text-white mb-2">Hawar Daun Bakteri</h4>
                            <p class="text-gray-400 text-sm flex-grow">Disebabkan oleh bakteri Xanthomonas oryzae pv. oryzae yang menyerang daun padi.</p>
                        </div>
                    </div>
                    <div class="glass-card rounded-2xl flex flex-col reveal" style="transition-delay: 450ms;">
                        <img src="{{asset('img')}}/penggerek.jpg" alt="Penggerek Batang Padi" class="w-full h-56 object-cover rounded-t-2xl" onerror="this.onerror=null;this.src='https://placehold.co/400x300?text=Penggerek';">
                         <div class="p-6 flex flex-col flex-grow">
                            <h4 class="text-xl font-bold text-white mb-2">Penggerek Batang</h4>
                            <p class="text-gray-400 text-sm flex-grow">Serangga yang merusak batang padi dengan membuat lubang dan memakan jaringan dalam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Fitur Prediksi Hama -->
        <section id="fitur" class="py-20 lg:py-24 bg-gray-900">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 content-wrapper">
                <div class="text-center mb-12 reveal">
                    <h2 class="text-3xl lg:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-amber-400">Fitur Prediksi Hama Cerdas</h2>
                    <p class="mt-4 text-lg text-gray-400 max-w-3xl mx-auto">HAMAXPERT menyediakan berbagai fitur canggih untuk membantu petani dalam mendeteksi dan mengatasi hama padi.</p>
                </div>
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center reveal">
                    <!-- Slider Gambar Fitur dari asset Anda -->
                    <div class="relative h-96 lg:h-[500px] bg-black/30 rounded-2xl shadow-2xl p-4 order-last lg:order-first">
                         <img src="{{asset('img')}}/fitur1.png" alt="Fitur 1" class="feature-image" onerror="this.onerror=null;this.src='https://placehold.co/600x400?text=Fitur+1';">
                         <img src="{{asset('img')}}/fitur2.png" alt="Fitur 2" class="feature-image" onerror="this.onerror=null;this.src='https://placehold.co/600x400?text=Fitur+2';">
                         <img src="{{asset('img')}}/fitur3.png" alt="Fitur 3" class="feature-image" onerror="this.onerror=null;this.src='https://placehold.co/600x400?text=Fitur+3';">
                         <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-4 z-10">
                            <button id="prevBtn" class="bg-white/20 hover:bg-white/30 text-white rounded-full w-12 h-12 flex items-center justify-center transition-all duration-300 backdrop-blur-sm shadow-lg"><i class="fas fa-chevron-left"></i></button>
                            <button id="nextBtn" class="bg-white/20 hover:bg-white/30 text-white rounded-full w-12 h-12 flex items-center justify-center transition-all duration-300 backdrop-blur-sm shadow-lg"><i class="fas fa-chevron-right"></i></button>
                         </div>
                    </div>
                    <!-- Daftar Fitur -->
                    <div class="space-y-4">
                        <div class="glass-card p-5 rounded-lg">
                            <h4 class="font-bold text-xl text-white mb-2">Deteksi Real-time</h4>
                            <p class="text-gray-300">Analisis suhu dan kelembaban secara real-time untuk mendeteksi potensi serangan hama.</p>
                        </div>
                         <div class="glass-card p-5 rounded-lg">
                            <h4 class="font-bold text-xl text-white mb-2">Pemetaan Lokasi & GPS</h4>
                            <p class="text-gray-300">Fitur peta interaktif dan deteksi GPS otomatis untuk analisis yang akurat.</p>
                        </div>
                         <div class="glass-card p-5 rounded-lg">
                            <h4 class="font-bold text-xl text-white mb-2">Rekomendasi Penanganan</h4>
                            <p class="text-gray-300">Memberikan saran penanganan yang tepat berdasarkan jenis hama dan kondisi lingkungan.</p>
                        </div>
                        <div class="glass-card p-5 rounded-lg">
                            <h4 class="font-bold text-xl text-white mb-2">Persebaran & Data Historis</h4>
                            <p class="text-gray-300">Visualisasi peta persebaran dan analisis data historis untuk prediksi serangan di masa depan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 border-t border-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; <span id="year"></span> HAMAXPERT. Semua Hak Cipta Dilindungi.</p>
            <p class="text-sm text-gray-500 mt-2">Dibuat untuk memberdayakan petani Indonesia.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // --- EFEK NAVBAR SAAT SCROLL ---
            const navbar = document.getElementById('navbar');
            const logo = document.getElementById('logo');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('navbar-scrolled');
                    logo.style.height = '40px'; 
                } else {
                    navbar.classList.remove('navbar-scrolled');
                    logo.style.height = '48px';
                }
            });

            // --- ANIMASI SAAT SCROLL (INTERSECTION OBSERVER) ---
            const revealElements = document.querySelectorAll('.reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });
            revealElements.forEach(el => observer.observe(el));

            // --- LOGIKA SLIDER FITUR ---
            const featureImages = document.querySelectorAll('.feature-image');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            let currentFeatureIndex = 0;

            function showFeature(index) {
                featureImages.forEach((img, i) => {
                    img.classList.toggle('active', i === index);
                });
            }

            nextBtn.addEventListener('click', () => {
                currentFeatureIndex = (currentFeatureIndex + 1) % featureImages.length;
                showFeature(currentFeatureIndex);
            });

            prevBtn.addEventListener('click', () => {
                currentFeatureIndex = (currentFeatureIndex - 1 + featureImages.length) % featureImages.length;
                showFeature(currentFeatureIndex);
            });
            
            // Tampilkan fitur pertama saat halaman dimuat
            showFeature(0);

            // --- UPDATE TAHUN DI FOOTER ---
            document.getElementById('year').textContent = new Date().getFullYear();
        });
    </script>
</body>
</html>
