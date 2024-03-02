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

<body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs"
    data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
        <div class="content-wrapper" style="height:100vh;margin-top:3rem;background-color:transparent;">
            <?php require_once('../inc/topBarNav.php') ?>
            <?php require_once('../inc/navigation.php') ?>
            <div class="col-lg-12" style="padding:25px;">

                <div class="card card-outline card-maroon rounded-0 shadow">
                    <div class="card-header">
                        <h3 class="card-title">List of Halls</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-flat btn-sm btn-primary" id="create_new"
                                data-toggle="modal" data-target="#AddHallModal">
                                <span class="fas fa-plus"></span> Add new
                            </button>

                            <div class="modal fade" id="AddHallModal" tabindex="-1" role="dialog"
                                aria-labelledby="AddHallModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add New Hall</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" id="hall-form" method="post">
                                            <div class="modal-body">
                                                <span id="uniqueCodeMessage" class="badge badge-info w-100 p-2">
                                                    The code of the hall must be unique.
                                                </span>
                                                <div class="form-group">
                                                    <label for="code" class="control-label">Code</label>
                                                    <input type="text" maxlength="50" name="code" id="code"
                                                        class="form-control form-control-border" placeholder="Hall-101"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="control-label">Name</label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control form-control-border"
                                                        placeholder="Enter hall Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="price" class="control-label">Price</label>
                                                    <input type="number" step="any" name="price" id="price"
                                                        class="form-control form-control-border text-right"
                                                        placeholder="0" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description" class="control-label">Description</label>
                                                    <textarea rows="3" name="description" id="description"
                                                        class="form-control form-control-sm rounded-0"
                                                        required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label">Hall Image</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input rounded-0"
                                                            id="customFile" name="img" onchange="previewImage(this)">
                                                        <label class="custom-file-label rounded-0"
                                                            for="customFile">Choose file</label>
                                                    </div>
                                                </div>
                                                <div class="form-group d-flex justify-content-center">
                                                    <img src="<?php echo base_url ?>dist/img/no-image-available.png"
                                                        id="cimg" class="img-fluid img-thumbnail bg-gradient-gray"
                                                        style="width: 100%;height: 15vh;object-fit: scale-down;object-position: center center;">
                                                </div>
                                                <div class="form-group">
                                                    <label for="status" class="control-label">Status</label>
                                                    <select name="status" id="status"
                                                        class="form-control form-control-border" required>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="container-fluid">
                                <table class="table table-bordered table-hover table-striped" id="hallsTable">
                                    <colgroup>
                                        <col width="5%">
                                        <col width="20%">
                                        <col width="20%">
                                        <col width="25%">
                                        <col width="15%">
                                        <col width="15%">
                                    </colgroup>
                                    <thead>
                                        <tr class="bg-gradient-maroon text-light">
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="halls">

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
                    <h5 class="modal-title" id="viewDetailsModalLabel">Hall Details</h5>
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
    <script>
        function previewImage(input) {
            var fileInput = input;
            var imgElement = $('#cimg')[0];
            var label = fileInput.nextElementSibling;
            var fileName = label.innerHTML;

            var reader = new FileReader();

            reader.onload = function (e) {
                imgElement.src = e.target.result;
            };

            reader.readAsDataURL(fileInput.files[0]);

            // Display the selected file name
            label.innerHTML = fileName;
        }
        function get_halls() {
            // Initialize DataTable
            let hallsTable = $('#hallsTable').DataTable({
                destroy: true, // Destroy the existing DataTable instance if any
                responsive: true, // Enable responsive design
                // Add other DataTable configurations as needed
            });

            $.ajax({
                url: '../ajax/get_halls.php', // Change the URL to the actual endpoint for fetching halls
                type: 'POST',
                data: { get_halls: 1 }, // You might need to adjust the data you're sending
                dataType: 'json',
                success: function (halls) {
                    // Clear existing data
                    hallsTable.clear().draw();

                    // Add new data
                    $.each(halls, function (index, hall) {
                        let row = [
                            (index + 1),
                            hall.code,
                            hall.name,
                            hall.price,
                            (hall.status == 1 ? 'Active' : 'Inactive'),
                            // Add more columns if needed
                            '<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">Action <span class="sr-only">Toggle Dropdown</span></button>' +
                            '<div class="dropdown-menu" role="menu">' +
                            '<a class="dropdown-item view_details" href="javascript:void(0)" data-id="' + hall.id + '"><span class="fa fa-eye text-dark"></span> View</a>' +
                            '<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="' + hall.id + '"><span class="fa fa-edit text-primary"></span> Edit</a>' +
                            '<div class="dropdown-divider"></div>' +
                            '<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="' + hall.id + '"><span class="fa fa-trash text-danger"></span> Delete</a>' +
                            '</div>'
                        ];

                        hallsTable.row.add(row).draw();
                    });
                },
                error: function (error) {
                    console.log('Failed to retrieve halls');
                }
            });
        }

        $(document).ready(function () {
            $(document).on('click', '.view_details', function () {
                var hallId = $(this).data('id');
                $.ajax({
                    url: '../ajax/get_hall_details.php',
                    type: 'POST',
                    data: { id: hallId },
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
                        var hallId = $(this).data('id');
                        $.ajax({
                            url: '../ajax/delete_hall.php',
                            type: 'POST',
                            data: { id: hallId },
                            success: function (response) {
                                showAlert('success', 'Hall deleted successfully');
                                get_halls();
                            },
                            error: function (error) {
                                console.log('Error:', error);
                                showAlert('error', 'Failed to delete Service');
                            }
                        });
                    }
                });
            });
            $('#hallsTable').DataTable();
            $('#hall-form').submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '../ajax/insert_hall.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response === '1') {
                            $('#AddHallModal').modal('hide');
                            showAlert('success', 'Hall inserted successfully');
                            $('#hall-form')[0].reset();
                            get_halls();
                        } else {
                            showAlert('error', 'Failed Insertion');
                        }

                    },
                    error: function (error) {
                        console.error('Ajax request failed:', error);
                    }
                });
            });

        });


        window.onload = function () {
            get_halls();
        }
    </script>

    <script src="<?php echo base_url ?>dist/js/global.js"></script>
</body>

</html>