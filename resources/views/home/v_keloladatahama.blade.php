@extends('home.v_template')

@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Kelola Data Hama</h4>
                </div>
                <div class="card-body">
                    <!-- Tabel Data Hama -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Hama</th>
                                <th>Icon</th>
                                <th>Kelembaban</th>
                                <th>Suhu</th>
                                <th>Rekomendasi</th>
                                <th style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hama as $h)
                            <tr>
                                <td>{{ $h->nama_hama }}</td>
                                <td><i class="{{ $h->icon }}"></i></td>
                                <td>{{ $h->min_humidity }}% - {{ $h->max_humidity }}%</td>
                                <td>{{ $h->min_temperature }}°C - {{ $h->max_temperature }}°C</td>
                                <td>
                                    @foreach(json_decode($h->rekomendasi) as $r)
                                        <li>{{ $r }}</li>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editHama({{ $h->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('delete.hama', $h->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data Hama</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('store.hama') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Hama</label>
                        <input type="text" name="nama_hama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Icon (Font Awesome)</label>
                        <input type="text" name="icon" class="form-control" value="fas fa-bug">
                    </div>
                    <div class="form-group">
                        <label>Rekomendasi (pisahkan dengan baris baru)</label>
                        <textarea name="rekomendasi" class="form-control" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Min Kelembaban (%)</label>
                                <input type="number" name="min_humidity" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Max Kelembaban (%)</label>
                                <input type="number" name="max_humidity" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Min Suhu (°C)</label>
                                <input type="number" name="min_temperature" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Max Suhu (°C)</label>
                                <input type="number" name="max_temperature" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Hama</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Hama</label>
                        <input type="text" name="nama_hama" id="edit_nama_hama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Icon</label>
                        <input type="text" name="icon" id="edit_icon" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Rekomendasi</label>
                        <textarea name="rekomendasi" id="edit_rekomendasi" class="form-control" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Min Kelembaban (%)</label>
                                <input type="number" name="min_humidity" id="edit_min_humidity" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Max Kelembaban (%)</label>
                                <input type="number" name="max_humidity" id="edit_max_humidity" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Min Suhu (°C)</label>
                                <input type="number" name="min_temperature" id="edit_min_temperature" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Max Suhu (°C)</label>
                                <input type="number" name="max_temperature" id="edit_max_temperature" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Event handler untuk tombol close
    $('.close, .btn-secondary').on('click', function() {
        $('#editModal').modal('hide');
    });

    // Event handler untuk menutup modal saat klik di luar modal
    $(window).on('click', function(event) {
        if ($(event.target).hasClass('modal')) {
            $('.modal').modal('hide');
        }
    });

    // Event handler untuk tombol escape
    $(document).on('keydown', function(event) {
        if (event.key === "Escape") {
            $('.modal').modal('hide');
        }
    });
});

function editHama(id) {
    // Ambil data hama berdasarkan ID
    $.ajax({
        url: '/get-hama-data/' + id,
        type: 'GET',
        success: function(data) {
            $('#edit_nama_hama').val(data.nama_hama);
            $('#edit_icon').val(data.icon);
            
            // Perbaikan penanganan rekomendasi
            let rekomendasi = data.rekomendasi;
            if (typeof rekomendasi === 'string') {
                try {
                    rekomendasi = JSON.parse(rekomendasi);
                } catch (e) {
                    console.error('Error parsing rekomendasi:', e);
                    rekomendasi = [];
                }
            }
            $('#edit_rekomendasi').val(Array.isArray(rekomendasi) ? rekomendasi.join('\n') : '');
            
            $('#edit_min_humidity').val(data.min_humidity);
            $('#edit_max_humidity').val(data.max_humidity);
            $('#edit_min_temperature').val(data.min_temperature);
            $('#edit_max_temperature').val(data.max_temperature);
            
            // Set action URL untuk form edit
            $('#editForm').attr('action', '/update-hama/' + id);
            
            // Tampilkan modal
            $('#editModal').modal('show');
        },
        error: function(error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data hama');
        }
    });
}
</script>
@endsection