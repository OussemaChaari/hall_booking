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
                        <h3 class="card-title">List of Services</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-flat btn-sm btn-primary" id="create_new"
                                data-toggle="modal" data-target="#AddServiceModal">
                                <span class="fas fa-plus"></span> Add new
                            </button>
                            <div class="modal fade" id="AddServiceModal" tabindex="-1" role="dialog"
                                aria-labelledby="AddServiceModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add New Hall</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" id="service-form" method="post">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="name" class="control-label">Name</label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control form-control-border"
                                                        placeholder="Enter Service Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description" class="control-label">Description</label>
                                                    <textarea rows="3" name="description" id="description"
                                                        class="form-control form-control-sm rounded-0"
                                                        required></textarea>
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
                                                <button type="submit" name="insert_service" class="btn btn-primary">Save
                                                    changes</button>
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
                                <table class="table table-bordered table-hover table-striped" id="servicesTable">
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
                                            <th>Date Created</th>
                                            <th>Service Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="services">

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
                    <h5 class="modal-title" id="viewDetailsModalLabel">Service Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="viewDetailsBody">
                    <!-- Details will be dynamically added here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function get_services() {
            $.ajax({
                url: '../ajax/get_services.php',
                type: 'POST',
                data: { get_services: 1 },
                dataType: 'json',
                success: function (services) {
                    let servicesTable = $('#servicesTable').DataTable({
                        destroy: true,
                        responsive: true,
                    });
                    servicesTable.clear().draw();
                    $.each(services, function (index, service) {
                        let row = $('<tr>');
                        row.append('<td>' + (index + 1) + '</td>');
                        row.append('<td>' + service.created_at + '</td>');
                        row.append('<td>' + service.name + '</td>');
                        row.append('<td>' + service.description + '</td>');
                        row.append('<td>' + (service.status == 1 ? 'Active' : 'Inactive') + '</td>');

                        let actionButton = $('<button>').attr({
                            type: 'button',
                            class: 'btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon',
                            'data-toggle': 'dropdown'
                        }).html('Action <span class="sr-only">Toggle Dropdown</span>');

                        let dropdownMenu = $('<div>').addClass('dropdown-menu').attr('role', 'menu');

                        let viewDetailsLink = $('<a>').addClass('dropdown-item view_details').attr({
                            href: 'javascript:void(0)',
                            'data-id': service.id
                        }).html('<span class="fa fa-eye text-dark"></span> View Details');

                        let editLink = $('<a>').addClass('dropdown-item edit_data').attr({
                            href: 'javascript:void(0)',
                            'data-id': service.id
                        }).html('<span class="fa fa-edit text-primary"></span> Edit');

                        let divider = $('<div>').addClass('dropdown-divider');

                        let deleteLink = $('<a>').addClass('dropdown-item delete_data').attr({
                            href: 'javascript:void(0)',
                            'data-id': service.id, 'data-name': service.name
                        }).html('<span class="fa fa-trash text-danger"></span> Delete');

                        dropdownMenu.append(viewDetailsLink, editLink, divider, deleteLink);

                        let cell6 = $('<td>').append(actionButton, dropdownMenu);
                        row.append(cell6);

                        servicesTable.row.add(row).draw();
                    });
                },
                error: function (error) {
                    console.log('Failed to retrieve services');
                }
            });
        }
        $(document).ready(function () {
            $('#description').summernote({
                height: '20vh'
            });
            $(document).on('click', '.view_details', function () {
                var serviceId = $(this).data('id');
                $.ajax({
                    url: '../ajax/get_service_details.php',
                    type: 'POST',
                    data: { id: serviceId },
                    dataType: 'json',
                    success: function (serviceDetails) {
                        $('#viewDetailsBody').html(
                            '<p><strong>Name:</strong> ' + serviceDetails.name + '</p>' +
                            '<p><strong>Description:</strong> ' + serviceDetails.description + '</p>' +
                            '<p><strong>Status:</strong> ' + (serviceDetails.status == 1 ? 'Active' : 'Inactive') + '</p>'
                        );
                        $('#viewDetailsModal').modal('show');
                    },
                    error: function (error) {
                        console.log('Error:', error);
                    }
                });
            });
            $(document).on('click', '.delete_data', function () {
                var serviceName = $(this).data('name');
                Swal.fire({
                    title: 'Are you sure to delete ' + serviceName + '?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var serviceId = $(this).data('id');
                        $.ajax({
                            url: '../ajax/delete_service.php',
                            type: 'POST',
                            data: { id: serviceId },
                            success: function (response) {
                                showAlert('success', 'Service deleted successfully');
                                get_services();
                            },
                            error: function (error) {
                                console.log('Error:', error);
                                showAlert('error', 'Failed to delete Service');
                            }
                        });
                    }
                });
            });
            $('#servicesTable').DataTable();
            $('#service-form').submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '../ajax/insert_service.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response === '1') {
                            $('#AddServiceModal').modal('hide');
                            showAlert('success', 'Service inserted successfully');
                            $('#service-form')[0].reset();
                            $('#description').summernote('code', '');
                            get_services();
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
            get_services();
        }
    </script>
    <script src="<?php echo base_url ?>dist/js/global.js"></script>
</body>

</html>