<?php require_once('../../config.php');
session_start();
require_once('../../alert.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: " . base_url . "admin/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('../../inc/header.php') ?>

<style>
    .dropdown-icon::after {
        margin-left: 0.25rem !important;
    }
</style>

<body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs"
    data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
        <div class="content-wrapper" style="height:100vh;margin-top:3rem;background-color:transparent;">
            <?php require_once('../inc/topBarNav.php') ?>
            <?php require_once('../inc/navigation.php') ?>
            <?php if (isset($_GET['msg'])) {
                $msg = urldecode($_GET['msg']);
                generateAlert($msg);
            }
            ?>
            <div class="col-lg-12" style="padding:25px;">
                <div class="card card-outline card-maroon rounded-0 shadow">
                    <div class="card-header">
                        <h3 class="card-title">List of Bookings</h3>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="container-fluid">
                                <table class="table table-hover table-striped table-bordered" id="bookingsTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Client Name</th>
                                            <th>Hall Name</th>
                                            <th>wedding_schedule</th>
                                            <th>Pending</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bookings">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel">Booking Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="viewDetailsContent">
                    <!-- Content will be dynamically added here through AJAX -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EditDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDetailsModalLabel">Edit Booking Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="editDetailsContent">
                    <!-- Content will be dynamically added here through AJAX -->
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#edit-form').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serializeArray();
                $.ajax({
                    url: '../ajax/update_booking.php', // Change this to the actual script handling the update
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        $('#EditDetailsModal').modal('hide');
                    },
                    error: function (error) {
                        console.log('Error:', error);
                    }
                });
            });
            $('#bookingsTable').DataTable();
            $(document).on('click', '.view_data', function () {
                var bookingId = $(this).data('id');
                $.ajax({
                    url: '../ajax/get_bookings_details.php',
                    type: 'POST',
                    data: { id: bookingId },
                    success: function (response) {
                        $('#editDetailsContent').html(response);
                        $('#EditDetailsModal').modal('show');
                    },
                    error: function (error) {
                        console.log('Error:', error);
                    }
                });
            });
            $(document).on('click', '.edit_data', function () {
                var bookingId = $(this).data('id');
                $.ajax({
                    url: '../ajax/edit_bookings.php',
                    type: 'POST',
                    data: { id: bookingId },
                    success: function (response) {
                        $('#viewDetailsContent').html(response);
                        $('#viewDetailsModal').modal('show');
                    },
                    error: function (error) {
                        console.log('Error:', error);
                    }
                });
            });
            $(document).on('click', '.delete_data', function () {
                Swal.fire({
                    title: 'Are you sure to delete ?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var bookingsId = $(this).data('id');
                        $.ajax({
                            url: '../ajax/delete_bookings.php',
                            type: 'POST',
                            data: { id: bookingsId },
                            success: function (response) {
                                showAlert('success', 'bookings deleted successfully');
                                get_bookings();
                            },
                            error: function (error) {
                                console.log('Error:', error);
                                showAlert('error', 'Failed to delete Service');
                            }
                        });
                    }
                });
            });
        });
        function get_bookings() {
            let bookingsTable = $('#bookingsTable').DataTable({
                destroy: true,
                responsive: true,
            });
            $.ajax({
                url: '../ajax/get_bookings.php',
                type: 'POST',
                data: { get_bookings: 1 },
                dataType: 'json',
                success: function (bookings) {
                    bookingsTable.clear();
                    $.each(bookings, function (index, booking) {
                        let pendingStatus = booking.pending == '0' ? '<span class="badge badge-warning">Pending</span>' : '<span class="badge badge-success">Approved</span>';
                        let row = [
                            index + 1,
                            booking.middlename || '',
                            booking.name || '',
                            booking.wedding_schedule || '',
                            pendingStatus,
                            '<div class="btn-group" role="group">' +
                            '<button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            'Action' +
                            '<span class="sr-only" style="margin-left: 5px;">Toggle Dropdown</span>' + // Add margin to move the caret
                            '</button>' +
                            '<div class="dropdown-menu" role="menu">' +
                            '<a class="dropdown-item view_data" href="javascript:void(0)" data-id="' + booking.id + '"><span class="fa fa-window-restore text-gray"></span> View</a>' +
                            '<div class="dropdown-divider"></div>' +
                            '<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="' + booking.id + '"><span class="fas fa-edit text-warning"></span> Edit</a>' +
                            '<div class="dropdown-divider"></div>' +
                            '<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="' + booking.id + '"><span class="fa fa-trash text-danger"></span> Delete</a>' +
                            '</div>' +
                            '</div>'
                        ];
                        bookingsTable.row.add(row);
                    });
                    bookingsTable.draw();
                },
                error: function (xhr, status, error) {
                    console.error('Failed to retrieve bookings. Status:', status, 'Error:', error);
                }
            });
        }
        window.onload = function () {
            get_bookings();
        }


    </script>

    <script src="<?php echo base_url ?>dist/js/global.js"></script>
</body>

</html>