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