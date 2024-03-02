<?php 
function generateAlert($message, $alertType = 'success', $position = 'top') {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            var Toast = Swal.mixin({
                toast: true,
                position: '$position',
                showConfirmButton: false,
                timer: 3500
            });
            Toast.fire({
                icon: '$alertType',
                title: '$message'
            }).then(() => {
                history.replaceState({}, document.title, window.location.pathname);
            });
        });
    </script>";
}
function globalAlert($message, $alertType = 'success', $position = 'top') {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            var Toast = Swal.mixin({
                toast: true,
                position: '$position',
                showConfirmButton: false,
                timer: 3500
            });
            Toast.fire({
                icon: '$alertType',
                title: '$message'
            });
        });
    </script>";
}
?>