document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('toggleSidebar').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent the default behavior of the anchor tag
        $('body').toggleClass('sidebar-collapse');
    });
});
function showAlert(type, message) {
    Swal.fire({
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 2000
    });
}