<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Hama Berdasarkan Kelembaban dan Suhu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Garamond:wght@400;700&display=swap">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: #012970;
        }
        .container {
            max-width: 1700px;
            margin-top: 30px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }
        .card-body {
            padding: 30px;
        }
        .card-title {
            font-size: 1.75rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #012970;
            font-family: 'Garamond', serif;
        }
        .card-title i {
            font-size: 2.5rem;
            margin-right: 15px;
            animation: logo-animation 4s infinite ease-in-out;
            color: #012970;
        }
        .icon {
            font-size: 4rem;
            color: #012970;
        }
        .text-primary {
            color: #012970 !important;
        }
        .mt-4 {
            margin-top: 1.5rem !important;
        }
        .lead {
            font-size: 1.5rem;
            color: #012970;
        }
        .data-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
        }
        .data-item {
            text-align: center;
            flex: 1;
        }
        .data-item h5 {
            margin-bottom: 10px;
            font-size: 1.2rem;
            color: #012970;
        }
        .data-item p {
            font-size: 1.1rem;
            color: #012970;
        }
        .date-period {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            color: #012970;
        }
        .date-period label {
            margin-right: 15px;
            font-size: 1.1rem;
            color: #012970;
        }
        .date-period select {
            font-size: 1.1rem;
            width: 180px;
            color: #012970;
        }
        .bg-gradient-primary {
            background: #ffffff !important;
        }
        .sidebar-brand {
            color: #012970;
            font-family: 'Garamond', serif;
        }
        .sidebar-brand-icon img {
            width: 50px;
        }
        .sidebar-brand-text {
            font-size: 1.5rem;
            margin-right: 10px;
            flex: 1;
            text-align: center;
            white-space: nowrap;
        }
        @keyframes logo-animation {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0);
            }
        }

        /* Custom styles for the sidebar */
        .sidebar {
            width: 300px;
            font-size: 10px !important; /* Lebar sidebar */
        }
        .sidebar.toggled {
            width: 80px; /* Lebar sidebar saat toggled */
        }
        .nav-link {
            font-size: 1.1rem; /* Ukuran font untuk tautan di sidebar */
            padding: 15px 25px; /* Menambah padding agar link terlihat lebih besar */
        }
        .nav-link i {
            font-size: 1.5rem; /* Ukuran ikon di sidebar */
            margin-right: 10px;
        }
        .sidebar-heading {
            padding-left: 25px;
        }
        .sidebar-divider {
            margin: 0 25px;
        }
        
    </style>
</head>
<body>
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-light accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-start" href="/home">
            <div class="sidebar-brand-icon">
                <img src="{{asset('img')}}/logo1.png" alt="Logo">
            </div>
            <div class="sidebar-brand-text mx-3">HamaXpert</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="/home">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Addons
        </div>

        <!-- Nav Item - Danger Zone -->
        <li class="nav-item">
            <a class="nav-link" href="/danger">
                <i class="fas fa-fw fa-bug"></i>
                <span>Prediksi Hama</span>
            </a>
        </li>

        <!-- Nav Item - Monitoring Kondisi Tanah -->
        <li class="nav-item">
            <a class="nav-link" href="/inputdata">
                <i class="fas fa-fw fa-tools"></i>
                <span>Upload Data Pertanian</span>
            </a>
            
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('data.show') }}">
                <i class="fas fa-seedling"></i>
                <span>Monitoring Hasil Pertanian</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('data.hasil') }}">
                <i class="fas fa-seedling"></i>
                <span>Hasil Pertanian</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/kondisicuaca">
                <i class="fas fa-cloud-sun"></i>
                <span>Monitoring Kondisi Cuaca</span>
            </a>
        </li>
        <!-- Tambahkan link ke kelola persediaan barang -->


<!-- Sidebar Item: Tambah Pengajuan Barang -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('pengajuanbarang.create') }}">
        <i class="fas fa-plus"></i>
        <span>Pengajuan Barang</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('pengajuanbarang.index') }}">
        <i class="fas fa-box"></i>
        <span>Kelola Persediaan Barang</span>
    </a>
</li>

        <li class="nav-item">
            <a class="nav-link" href="/monitoring">
                <i class="fas fa-fw fa-broadcast-tower"></i>
                <span>Control Device</span>
            </a>
        </li>

        <!-- Nav Item - History Laporan -->
        <li class="nav-item">
            <a class="nav-link" href="/history">
                <i class="fas fa-fw fa-calendar"></i>
                <span>Laporan</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Nav Item - Logout -->
        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin mau keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" dibawah jika kamu sudah menyudahi sesimu!.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sidebarToggle').on('click', function () {
                $('#accordionSidebar').toggleClass('toggled');
            });
        });
    </script>
</body>
</html>
