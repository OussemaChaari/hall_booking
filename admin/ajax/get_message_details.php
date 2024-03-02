<?php
require_once('../../config.php');
session_start();

$response = array(); // Initialize the response array

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $messageId = mysqli_real_escape_string($con, $_POST['id']);
    $query = "SELECT * FROM messages WHERE id = '$messageId'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $messageDetails = mysqli_fetch_assoc($result);

        

        // Prepare the HTML content
        ob_start(); // Start output buffering
        ?>
        <dl>
            <dt class="text-maroon">Inquirer</dt>
            <dd class="pl-4 font-weight-bold"><?php echo $messageDetails['fullname']; ?></dd>
            <dt class="text-maroon">Email</dt>
            <dd class="pl-4 font-weight-bold"><?php echo $messageDetails['email']; ?></dd>
            <dt class="text-maroon">Contact #</dt>
            <dd class="pl-4 font-weight-bold"><?php echo $messageDetails['contact']; ?></dd>
            <dt class="text-maroon">Message</dt>
            <dd class="pl-4 font-weight-bold"><?php echo $messageDetails['message']; ?></dd>
            <dt class="text-maroon">Status</dt>
            <dd class="pl-4 font-weight-bold"><?php echo ($messageDetails['read'] == 1 ? 'Read' : 'Unread'); ?></dd>
        </dl>
        <?php
        $response['html_content'] = ob_get_clean(); // Get and clean the buffered output
        if ($messageDetails['read'] == 0) {
            // Perform the update only when 'read' is equal to 0
            $updateQuery = "UPDATE `messages` SET `read` = 1 WHERE id = '{$messageId}'";
            $updateResult = mysqli_query($con, $updateQuery);
            
            if ($updateResult) {
                $response['success'] = true;
                $response['message'] = 'Message read successfully.';
            } else {
                $response['success'] = false;
                $response['message'] = 'Error updating message status.';
            }
        }
    } else {
        $response['error'] = 'Failed to retrieve message details';
    }

    echo json_encode($response);
} else {
    $response['error'] = 'Invalid request';
    echo json_encode($response);
}
?>