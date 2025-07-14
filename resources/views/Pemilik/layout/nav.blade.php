<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Garamond:wght@400;700&display=swap">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: #012970; /* Default text color */
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
            color: #012970; /* Card title color */
            font-family: 'Garamond', serif; /* Update to Garamond */
        }
        .card-title i {
            font-size: 2.5rem;
            margin-right: 15px;
            animation: logo-animation 4s infinite ease-in-out;
            color: #012970; /* Icon color */
        }
        .icon {
            font-size: 4rem;
            color: #012970; /* Icon color */
        }
        .text-primary {
            color: #012970 !important; /* Primary text color */
        }
        .mt-4 {
            margin-top: 1.5rem !important;
        }
        .lead {
            font-size: 1.5rem;
            color: #012970; /* Lead text color */
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
            color: #012970; /* Data item header color */
        }
        .data-item p {
            font-size: 1.1rem;
            color: #012970; /* Data item text color */
        }
        .date-period {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            color: #012970; /* Date-period text color */
        }
        .date-period label {
            margin-right: 15px;
            font-size: 1.1rem;
            color: #012970; /* Label color */
        }
        .date-period select {
            font-size: 1.1rem;
            width: 180px;
            color: #012970; /* Select text color */
        }
        .bg-gradient-primary {
            background: #ffffff !important; /* Sidebar background color */
        }
        .sidebar-brand {
            color: #012970; /* Sidebar brand text color */
            font-family: 'Garamond', serif; /* Update to Garamond */
        }
        .sidebar-brand-icon img {
            width: 50px;
            
        }
        
        
        
        .sidebar-brand-text {
        font-size: 1.5rem; /* Font size for text */
        margin-right: 10;
        flex: 1; /* Makes the text element take up available space */
        text-align: center; /* Center-aligns the text within its container */
        white-space: nowrap; /* Prevents text from wrapping */
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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-light accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-start" href="/pemilik">
            <div class="sidebar-brand-icon">
                <img src="{{asset('img')}}/logo1.png" alt="Logo">
            </div>
            <div class="sidebar-brand-text mx-3">HAMAXPERT</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="/pemilik">
                <i class="fas fa-fw fa-home"></i>
                <span>Prediksi Hama</span>
            </a>
        </li>

        <!-- Nav Item - Deteksi Hama -->
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('pemilik.danger') }}">
                <i class="fas fa-fw fa-bug"></i>
                <span>Deteksi Hama</span>
            </a>
        </li> --}}

        <!-- Nav Item - Pengajuan Hama -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pemilik.pengajuanhama.create') }}">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Pengajuan Hama</span>
            </a>
        </li>

        <!-- Nav Item - Input Data Pertanian -->
        <li class="nav-item">
            <a class="nav-link" href="/inputdatapertanian">
                <i class="fas fa-fw fa-bug"></i>
                <span>Input Data Pertanian</span>
            </a>
        </li>

        <!-- Nav Item - Hasil Pertanian -->
        <li class="nav-item">
            <a class="nav-link" href="/hasilpertanianpetani">
                <i class="fas fa-fw fa-tools"></i>
                <span>Hasil Pertanian</span>
            </a>
        </li>

        <!-- Tambahkan menu Monitoring Hama -->
       

        <!-- Tambahkan menu Monitoring Cuaca -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('monitoringcuaca.index') }}">
                <i class="fas fa-cloud-sun"></i>
                <span>Monitoring Cuaca</span>
            </a>
        </li>

        <!-- Nav Item - Pengajuan Barang -->
        

        <!-- Nav Item - History Laporan -->
        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->
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
