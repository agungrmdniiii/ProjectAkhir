    @extends('home.v_template')

    @section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Control Device</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
        <style>
            .device-control-wrapper {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f7f6;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .device-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .device-container h1.text-center {
        color: #012970;
        font-weight: 700;
        margin-bottom: 30px;
        font-size: 2rem;
    }

    .device {
        border: 1px solid #dee2e6;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        background: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .device-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .device-header h4 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .status-indicator {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #dee2e6;
    }

    .device-status {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .device-status button {
        font-size: 0.80rem; /* Ukuran font diperkecil */
        border-radius: 50%;
        width: 60px;
        height: 60px;
        margin: 0 5px;
        padding: 0;
        line-height: 60px;
        text-align: center;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .device-status .btn-inactive {
        background-color: #dc3545;
    }

    .device-status .btn-active {
        background-color: #28a745;
    }

    .device-status button:hover {
        transform: scale(1.1);
    }

    .btn-container {
        display: flex;
        justify-content: space-between;
    }

    .btn-container button {
        flex: 1;
        margin: 0 5px;
        border-radius: 20px;
        padding: 10px 15px;
        font-size: 0.875rem;
    }

    .btn-success {
        background-color: #28a745;
        color: #fff;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .dropdown-time {
        margin-top: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .dropdown-time select {
        padding: 5px 10px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        font-size: 1rem;
    }
        </style>
    </head>

    <body>
        <div class="device-control-wrapper">
            <div class="device-container">
                <h1 class="text-center">Kontrol Device</h1>
                <div class="row">
                    <!-- Device 1 -->
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="device" data-device="1">
                            <div class="device-header">
                                <h4>Perangkat 1</h4>
                                <div class="status-indicator" style="background-color: #dc3545;"></div>
                            </div>
                            <div class="device-status">
                                <button class="btn btn-inactive btn-device" data-device="1" data-button="1">1</button>
                                <button class="btn btn-inactive btn-device" data-device="1" data-button="2">2</button>
                                <button class="btn btn-inactive btn-device" data-device="1" data-button="3">3</button>
                                <button class="btn btn-inactive btn-device" data-device="1" data-button="4">4</button>
                            </div>
                            <div class="btn-container">
                                <button class="btn btn-success btn-all" data-device="1">Aktifkan Semua</button>
                                <button class="btn btn-danger btn-off-all" data-device="1">Matikan Semua</button>
                            </div>
                        </div>
                    </div>
                    <!-- Device 2 -->
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="device" data-device="2">
                            <div class="device-header">
                                <h4>Perangkat 2</h4>
                                <div class="status-indicator" style="background-color: #dc3545;"></div>
                            </div>
                            <div class="device-status">
                                <button class="btn btn-inactive btn-device" data-device="2" data-button="1">1</button>
                                <button class="btn btn-inactive btn-device" data-device="2" data-button="2">2</button>
                                <button class="btn btn-inactive btn-device" data-device="2" data-button="3">3</button>
                                <button class="btn btn-inactive btn-device" data-device="2" data-button="4">4</button>
                            </div>
                            <div class="btn-container">
                                <button class="btn btn-success btn-all" data-device="2">Aktifkan Semua</button>
                                <button class="btn btn-danger btn-off-all" data-device="2">Matikan Semua</button>
                            </div>
                        </div>
                    </div>
                    <!-- Device 3 -->
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="device" data-device="3">
                            <div class="device-header">
                                <h4>Perangkat 3</h4>
                                <div class="status-indicator" style="background-color: #dc3545;"></div>
                            </div>
                            <div class="device-status">
                                <button class="btn btn-inactive btn-device" data-device="3" data-button="1">1</button>
                                <button class="btn btn-inactive btn-device" data-device="3" data-button="2">2</button>
                                <button class="btn btn-inactive btn-device" data-device="3" data-button="3">3</button>
                                <button class="btn btn-inactive btn-device" data-device="3" data-button="4">4</button>
                            </div>
                            <div class="btn-container">
                                <button class="btn btn-success btn-all" data-device="3">Aktifkan Semua</button>
                                <button class="btn btn-danger btn-off-all" data-device="3">Matikan Semua</button>
                            </div>
                        </div>
                    </div>
                    <!-- Device 4 -->
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="device" data-device="4">
                            <div class="device-header">
                                <h4>Perangkat 4</h4>
                                <div class="status-indicator" style="background-color: #dc3545;"></div>
                            </div>
                            <div class="device-status">
                                <button class="btn btn-inactive btn-device" data-device="4" data-button="1">1</button>
                                <button class="btn btn-inactive btn-device" data-device="4" data-button="2">2</button>
                                <button class="btn btn-inactive btn-device" data-device="4" data-button="3">3</button>
                                <button class="btn btn-inactive btn-device" data-device="4" data-button="4">4</button>
                            </div>
                            <div class="btn-container">
                                <button class="btn btn-success btn-all" data-device="4">Aktifkan Semua</button>
                                <button class="btn btn-danger btn-off-all" data-device="4">Matikan Semua</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Device Control -->
                    
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="device">
                            <div class="device-header"style='justify-content:center;'>
                                <h4>Device Control</h4>
                            </div>
                            <div class="device-status">
                                <button class="btn btn-success" id="activate-all">Aktifkan</button>
                                <button class="btn btn-danger" id="deactivate-all">Matikan</button>
                            </div>
                            <div class="dropdown-time">
                                
                                <select id="time-duration" class="form-control">
                                    <option value="5">5 Detik</option>
                                    <option value="10">10 Detik</option>
                                    <option value="30">30 Detik</option>
                                    <option value="60">1 Menit</option>
                                    <option value="300">5 Menit</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scripts -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>
                $(document).ready(function () {
        function updateDeviceButtons(deviceId, status) {
            const buttons = $(`.device[data-device="${deviceId}"] .btn-device`);
            if (status === 'activate') {
                buttons.addClass('btn-active').removeClass('btn-inactive');
            } else {
                buttons.addClass('btn-inactive').removeClass('btn-active');
            }
            updateDeviceStatus(deviceId);
        }

        function updateDeviceStatus(deviceId) {
            const device = $(`.device[data-device="${deviceId}"]`);
            const activeButtons = device.find('.btn-active').length;
            const statusIndicator = device.find('.status-indicator');
            if (activeButtons > 0) {
                statusIndicator.css('background-color', '#28a745');
            } else {
                statusIndicator.css('background-color', '#dc3545');
            }
        }

        function updateAllDevices(status) {
            $('.device').each(function () {
                const deviceId = $(this).data('device');
                updateDeviceButtons(deviceId, status);
            });
        }

        // Activate all buttons for a specific device
        $('.btn-all').click(function () {
            const deviceId = $(this).data('device');
            updateDeviceButtons(deviceId, 'activate');
        });

        // Deactivate all buttons for a specific device
        $('.btn-off-all').click(function () {
            const deviceId = $(this).data('device');
            updateDeviceButtons(deviceId, 'deactivate');
        });

        // Activate all buttons for all devices
        $('#activate-all').click(function () {
            updateAllDevices('activate');
        });

        // Deactivate all buttons for all devices
        $('#deactivate-all').click(function () {
            updateAllDevices('deactivate');
        });

        $('#time-duration').change(function () {
            const duration = $(this).val();
            $('.btn-active').each(function () {
                const button = $(this);
                setTimeout(() => {
                    button.removeClass('btn-active').addClass('btn-inactive');
                    updateDeviceStatus(button.closest('.device').data('device'));
                }, duration * 1000);
            });
        });

        $('.btn-device').click(function () {
            $(this).toggleClass('btn-active btn-inactive');
            updateDeviceStatus($(this).closest('.device').data('device'));
        });
    });
            </script>
        </div>
    </body>

    </html>
    @endsection