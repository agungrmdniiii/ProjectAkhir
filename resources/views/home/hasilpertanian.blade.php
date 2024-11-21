@extends('home.v_template')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pertanian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #012970;
        }
        .container {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #012970;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Hasil Pertanian</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Jumlah Pestisida</th>
                    <th>Lama Panen</th>
                    <th>Hasil Panen</th>
                    <th>Luas Lahan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataPertanian as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td> <!-- Auto-increment number -->               
                    <td>{{ $data->jumlah_pestisida }}</td>
                    <td>{{ $data->lama_panen }}</td>
                    <td>{{ $data->hasil_panen }}</td>
                    <td>{{ $data->luas_lahan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection