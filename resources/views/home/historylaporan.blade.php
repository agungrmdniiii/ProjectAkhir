@extends('home.v_template')

@section('title', 'Kelola Rumah Warga')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    
    <style>
        .full-width-container {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .card-body {
            overflow-x: auto;
        }

        .table th, .table td {
            white-space: nowrap;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4e73df;
        }

        .btn-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-group .btn {
        font-size: 0.875rem; /* Ukuran font yang lebih kecil untuk tombol */
        padding: 10px 20px; /* Padding yang lebih konsisten */
        height: auto; /* Tinggi tombol otomatis sesuai konten */
        line-height: 1.5; /* Tinggi baris lebih konsisten */
        white-space: nowrap; /* Pastikan teks tidak terpotong */
    }

        .form-control-file {
            font-size: 0.875rem; /* Ukuran font yang lebih kecil untuk input file */
        }

        .year-select {
            font-size: 0.875rem; /* Ukuran font yang lebih kecil */
            height: 38px; /* Tinggi yang sama untuk dropdown */
        }
    </style>
    

   
</head>
<body>

<div class="container-fluid mt-4 full-width-container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="header-title">Laporan</div>
                    <div class="btn-group">
                        <!-- Dropdown to select year -->
                        <select class="form-control year-select" onchange="filterByYear(this.value)">
                            <option value="">Pilih Tahun</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>
                        <!-- Button to download Excel template -->
                        <a href="{{ asset('template.xlsx') }}" class="btn btn-success" download>Download Template</a>
                        <button class="btn btn-success" type="button" onclick="downloadTableAsExcel()">Export Data</button>
                        <!-- Form import -->
                        <form  class="d-inline">
                            @csrf
                            
                            <button class="btn btn-success" type="submit">Import Data</button>
                        </form>
                    </div>
                </div>  
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Jenis Kelapa</th>
                                <th class="text-center">Varietas</th>
                                <th class="text-center">Tanggal Salur</th>
                                <th class="text-center">Jumlah (batang)</th>
                                <th class="text-center">Tahun Produksi</th>
                                <th class="text-center">Tujuan</th>
                                <th class="text-center">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example rows (updated with new data) -->
                            <tr data-year="2022">
                                <td class="text-center">1</td>
                                <td class="text-center">Dalam</td>
                                <td class="text-center">Bali</td>
                                <td class="text-center">30 Desember 2022</td>
                                <td class="text-center">2.143</td>
                                <td class="text-center">2022</td>
                                <td class="text-center">Kab. Pemalang</td>
                                <td class="text-center">Polibag</td>
                            </tr>
                            <tr data-year="2022">
                                <td class="text-center">2</td>
                                <td class="text-center">Dalam</td>
                                <td class="text-center">Bali</td>
                                <td class="text-center">30 Desember 2022</td>
                                <td class="text-center">2.200</td>
                                <td class="text-center">2022</td>
                                <td class="text-center">Kab. Pemalang</td>
                                <td class="text-center">Polibag</td>
                            </tr>
                            <tr data-year="2023">
                                <td class="text-center">1</td>
                                <td class="text-center">Dalam</td>
                                <td class="text-center">Bojong bulat</td>
                                <td class="text-center">17 Januari 2024</td>
                                <td class="text-center">25</td>
                                <td class="text-center">2023</td>
                                <td class="text-center">Kab. Blora</td>
                                <td class="text-center">Polibag</td>
                            </tr>
                            <tr data-year="2023">
                                <td class="text-center">2</td>
                                <td class="text-center">Dalam</td>
                                <td class="text-center">Bojong bulat</td>
                                <td class="text-center">2 Februari 2024</td>
                                <td class="text-center">1.800</td>
                                <td class="text-center">2023</td>
                                <td class="text-center">Kab. Aceh Tenggara</td>
                                <td class="text-center">Polibag</td>
                            </tr>
                            <tr data-year="2023">
                                <td class="text-center">3</td>
                                <td class="text-center">Dalam</td>
                                <td class="text-center">Bojong bulat</td>
                                <td class="text-center">2 Februari 2024</td>
                                <td class="text-center">600</td>
                                <td class="text-center">2023</td>
                                <td class="text-center">Kab. Aceh Tenggara</td>
                                <td class="text-center">Polibag</td>
                            </tr>
                            <tr data-year="2023">
                                <td class="text-center">4</td>
                                <td class="text-center">Dalam</td>
                                <td class="text-center">Bojong bulat</td>
                                <td class="text-center">2 Februari 2024</td>
                                <td class="text-center">610</td>
                                <td class="text-center">2023</td>
                                <td class="text-center">Kab. Aceh Tenggara</td>
                                <td class="text-center">Polibag</td>
                            </tr>
                            <tr data-year="2024">
                                <td class="text-center">1</td>
                                <td class="text-center">Kelapa Genjah</td>
                                <td class="text-center">Kuning Bali</td>
                                <td class="text-center">5 Juli 2022</td>
                                <td class="text-center">435</td>
                                <td class="text-center">2021</td>
                                <td class="text-center">Kab. Semarang</td>
                                <td class="text-center">Polibag</td>
                            </tr>
                            <tr data-year="2024">
                                <td class="text-center">2</td>
                                <td class="text-center">Kelapa Genjah</td>
                                <td class="text-center">Kuning Bali</td>
                                <td class="text-center">5 Juli 2022</td>
                                <td class="text-center">454</td>
                                <td class="text-center">2021</td>
                                <td class="text-center">Kab. Semarang</td>
                                <td class="text-center">Polibag</td>
                            </tr>
                            <tr data-year="2024">
                                <td class="text-center">3</td>
                                <td class="text-center">Kelapa Genjah</td>
                                <td class="text-center">Kuning Bali</td>
                                <td class="text-center">8 Juli 2022</td>
                                <td class="text-center">455</td>
                                <td class="text-center">2021</td>
                                <td class="text-center">Kab. Semarang</td>
                                <td class="text-center">Polibag</td>
                            </tr>
                            <tr data-year="2024">
                                <td class="text-center">4</td>
                                <td class="text-center">Kelapa Genjah</td>
                                <td class="text-center">Kuning Bali</td>
                                <td class="text-center">8 Juli 2022</td>
                                <td class="text-center">501</td>
                                <td class="text-center">2021</td>
                                <td class="text-center">Kab. Semarang</td>
                                <td class="text-center">Polibag</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
@endsection


