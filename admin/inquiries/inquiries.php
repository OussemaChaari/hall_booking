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
                <div class="card card-outline card-maroon rounded-0">
                    <div class="card-header">
                        <h3 class="card-title">List of Inquiries</h3>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="container-fluid">
                                <table class="table table-hover table-striped" id="messagesDataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Inquirer</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="messagesTable">

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
                    <h5 class="modal-title" id="viewDetailsModalLabel">Message Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="viewDetailsBody">
                </div>
            </div>
        </div>
    </div>
    <script>
        function get_messages() {
            $.ajax({
                url: '../ajax/get_message.php',
                type: 'POST',
                data: { get_messages: 1 },
                dataType: 'json',
                success: function (messages) {
                    let messagesTable = $('#messagesTable');
                    messagesTable.empty();
                    $.each(messages, function (index, message) {
                        let row = $('<tr>');
                        row.append('<td>' + (index + 1) + '</td>');
                        row.append('<td>' + message.fullname + '</td>');
                        row.append('<td>' + message.email + '</td>');
                        row.append('<td>' + message.contact + '</td>');
                        row.append('<td>' + message.message + '</td>');

                        let statusBadgeClass = message.read == 1 ? 'badge-success' : 'badge-primary';
                        let statusBadge = $('<span>').addClass('badge badge-pill ' + statusBadgeClass).text(message.read == 1 ? 'Read' : 'Unread');
                        let cell6 = $('<td>').append(statusBadge);
                        row.append(cell6);

                        let actionButton = $('<button>').attr({
                            type: 'button',
                            class: 'btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon',
                            'data-toggle': 'dropdown'
                        }).html('Action <span class="sr-only">Toggle Dropdown</span>');

                        let dropdownMenu = $('<div>').addClass('dropdown-menu').attr('role', 'menu');
                        let viewDetailsLink = $('<a>').addClass('dropdown-item view_details').attr({
                            href: 'javascript:void(0)',
                            'data-id': message.id
                        }).html('<span class="fa fa-eye text-dark"></span> View');
                        let divider = $('<div>').addClass('dropdown-divider');
                        let deleteLink = $('<a>').addClass('dropdown-item delete_data').attr({
                            href: 'javascript:void(0)',
                            'data-id': message.id
                        }).html('<span class="fa fa-trash text-danger"></span> Delete');

                        dropdownMenu.append(viewDetailsLink, divider, deleteLink);
                        let cell7 = $('<td>').append(actionButton, dropdownMenu);
                        row.append(cell7);

                        messagesTable.append(row);
                    });
                },
                error: function (error) {
                    console.log('Failed to retrieve messages');
                }
            });

        }

        $(document).ready(function () {
            $(document).on('click', '.view_details', function () {
                var messageId = $(this).data('id');
                $.ajax({
                    url: '../ajax/get_message_details.php',
                    type: 'POST',
                    data: { id: messageId },
                    dataType: 'json',
                    success: function (response) {
                        $('#viewDetailsBody').html(response.html_content);
                        $('#viewDetailsModal').modal('show');

                        if (response.success == true) {
                            closeModal();
                            showAlert('success', 'Message readed');
                        }

                    },
                    error: function (error) {
                        console.log('Error:', error);
                    }
                });
            });
            $(document).on('click', '.delete_data', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var messageId = $(this).data('id');
                        $.ajax({
                            url: '../ajax/delete_message.php',
                            type: 'POST',
                            data: { id: messageId },
                            success: function (response) {
                                showAlert('success', 'Message deleted successfully');
                                get_messages();
                            },
                            error: function (error) {
                                console.log('Error:', error);
                                showAlert('error', 'Failed to delete message');
                            }
                        });
                    }
                });
            });
        });
        function closeModal() {
            get_messages();
        }
        window.onload = function () {
            get_messages();
        }
    </script>
    <script src="<?php echo base_url ?>dist/js/global.js"></script>
</body>

</html>