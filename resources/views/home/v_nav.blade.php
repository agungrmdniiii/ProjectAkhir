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
            font-size: 10px !important;
        }
        .sidebar.toggled {
            width: 80px;
        }
        .nav-link {
            font-size: 1.1rem;
            padding: 15px 25px;
        }
        .nav-link i {
            font-size: 1.5rem;
            margin-right: 10px;
        }
        .sidebar-heading {
            padding-left: 25px;
        }
        .sidebar-divider {
            margin: 0 25px;
        }
        
        /* Tambahan CSS untuk dropdown */
        .collapse-inner {
            padding: 0.5rem 1rem;
        }
        .collapse-item {
            display: block;
            padding: 0.5rem 1rem;
            color: #012970;
            text-decoration: none;
            border-radius: 0.35rem;
            white-space: nowrap;
        }
        .collapse-item:hover {
            background-color: #f8f9fc;
            text-decoration: none;
            color: #012970;
        }
        .collapse-item i {
            font-size: 0.85rem;
        }
        .collapse {
            transition: all 0.2s ease;
        }

        .nav-link[data-toggle="collapse"].collapsed:after {
            content: '\f105';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            float: right;
            margin-left: auto;
        }

        .nav-link[data-toggle="collapse"]:after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            float: right;
            margin-left: auto;
        }

        .nav-link[data-toggle="collapse"] {
            position: relative;
        }

        /* CSS untuk dropdown */
        .nav-item .collapse {
            display: none;
        }

        .nav-item .collapse.show {
            display: block;
        }

        .nav-link[data-toggle="collapse"]:after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            float: right;
            margin-left: auto;
            transition: transform 0.3s;
        }

        .nav-link[data-toggle="collapse"].collapsed:after {
            transform: rotate(-90deg);
        }

        .collapse-inner {
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 0.35rem;
            margin: 0 1rem;
        }

        .collapse-item {
            display: block;
            padding: 0.5rem 1rem;
            color: #012970;
            text-decoration: none;
            border-radius: 0.35rem;
            white-space: nowrap;
        }

        .collapse-item:hover {
            background-color: #f8f9fc;
            text-decoration: none;
            color: #012970;
        }

        /* CSS untuk tanda panah dropdown */
        .nav-link[data-bs-toggle="collapse"]:after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            float: right;
            margin-left: auto;
            transition: transform 0.3s;
        }

        .nav-link[data-bs-toggle="collapse"].collapsed:after {
            transform: rotate(-90deg);
        }

        /* Pastikan tanda panah tetap terlihat */
        .nav-link[data-bs-toggle="collapse"] {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-link[data-bs-toggle="collapse"] span {
            flex: 1;
        }

        /* CSS untuk menu sidebar */
        .nav-item {
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-link {
            font-size: 0.9rem;  /* Ukuran font dikecilkan */
            padding: 12px 20px;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .nav-link i {
            font-size: 1.1rem;  /* Ukuran icon dikecilkan */
            min-width: 25px;    /* Lebar minimum untuk icon */
            margin-right: 8px;  /* Jarak antara icon dan text */
        }

        .nav-link span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Memperlebar sidebar sedikit */
        .sidebar {
            width: 280px;
        }

        /* Mengatur ulang padding untuk dropdown items */
        .collapse-item {
            font-size: 0.85rem;
            padding: 8px 15px;
            white-space: nowrap;
        }

        .collapse-header {
            padding: 0.5rem 1rem;
            margin-bottom: 0;
            font-size: 0.65rem;
            color: #012970;
            text-transform: uppercase;
            font-weight: bold;
        }

        .collapse-inner {
            padding: 0.5rem 0;
            min-width: 10rem;
            font-size: 0.85rem;
            margin: 0 0.7rem;
            background-color: #fff;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .collapse-item {
            display: block;
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
            color: #012970;
            text-decoration: none;
            border-radius: 0.35rem;
            white-space: nowrap;
        }

        .collapse-item:hover {
            background-color: #f8f9fc;
            color: #012970;
            text-decoration: none;
        }

        .collapse-item i {
            margin-right: 0.5rem;
            font-size: 0.85rem;
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
        {{-- <li class="nav-item">
            <a class="nav-link" href="/home">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li> --}}

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
        <li class="nav-item">
            <a class="nav-link" href="{{ route('manage.hama') }}">
                <i class="fas fa-bug"></i>
                <span>Kelola Data Hama</span>
            </a>
        </li>
        <!-- Nav Item - Data Pertanian Dropdown -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDataPertanian"
                aria-expanded="false" aria-controls="collapseDataPertanian">
                <i class="fas fa-fw fa-leaf"></i>
                <span>Data Pertanian</span>
            </a>
            <div id="collapseDataPertanian" class="collapse" data-bs-parent="#accordionSidebar">
                <div class="collapse-inner">
                    <a class="collapse-item" href="/inputdata">
                        <i class="fas fa-fw fa-upload mr-2"></i>Upload Data
                    </a>
                    <a class="collapse-item" href="{{ route('data.show') }}">
                        <i class="fas fa-fw fa-chart-line mr-2"></i>Monitoring Hasil
                    </a>
                    <a class="collapse-item" href="{{ route('data.hasil') }}">
                        <i class="fas fa-fw fa-seedling mr-2"></i>Hasil Pertanian
                    </a>
                </div>
            </div>
        </li>
<!-- Nav Item - Manajemen Barang Dropdown -->
{{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseManajemenBarang"
        aria-expanded="false" aria-controls="collapseManajemenBarang">
        <i class="fas fa-boxes"></i>
        <span>Manajemen Barang</span>
    </a>
    <div id="collapseManajemenBarang" class="collapse" data-bs-parent="#accordionSidebar">
        <div class="collapse-inner">
            
            <a class="collapse-item" href="{{ route('pengajuanbarang.edit', ['pengajuanbarang' => 0]) }}">
                <i class="fas fa-warehouse mr-2"></i>Kelola Persediaan
            </a>
            <a class="collapse-item" href="{{ route('pengajuanbarang.create') }}">
                <i class="fas fa-file-alt mr-2"></i>Buat Pengajuan
            </a>
            <a class="collapse-item" href="{{ route('pengajuanbarang.index') }}">
                <i class="fas fa-list-alt mr-2"></i>Daftar Pengajuan
            </a>
        </div>
    </div>
</li> --}}
        <li class="nav-item">
            <a class="nav-link" href="/kondisicuaca">
                <i class="fas fa-cloud-sun"></i>
                <span>Monitoring Kondisi Cuaca</span>
            </a>
        </li>

        <!-- Nav Item - Pengajuan Hama -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pengajuanhama.create') }}">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Laporkan Hama</span>
            </a>
        </li>

        <!-- Nav Item - Daftar Pengajuan Hama -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pengajuanhama.index') }}">
                <i class="fas fa-list"></i>
                <span>Daftar Laporan Hama</span>
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
    <!-- Logout Modal-->
<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Yakin mau keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Pilih "Yes" di bawah jika kamu ingin keluar dari sesi ini.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Sidebar toggle
            $('#sidebarToggle').on('click', function() {
                $('#accordionSidebar').toggleClass('toggled');
            });

            // Dropdown toggle
            $('[data-bs-toggle="collapse"]').on('click', function(e) {
                e.preventDefault();
                const $this = $(this);
                const $target = $($this.data('bs-target'));
                
                // Toggle collapse
                if ($target.hasClass('show')) {
                    $target.collapse('hide');
                } else {
                    $('.collapse').collapse('hide');
                    $target.collapse('show');
                }
                
                // Toggle collapsed class
                $this.toggleClass('collapsed', !$target.hasClass('show'));
            });
        });
    </script>
</body>
</html>
