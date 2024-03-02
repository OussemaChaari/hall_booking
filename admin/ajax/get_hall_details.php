<?php
require_once('../../config.php'); // Adjust the path as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $hallId = mysqli_real_escape_string($con, $_POST['id']);
    $query = "SELECT * FROM halls WHERE id = '$hallId'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $hallDetails = mysqli_fetch_assoc($result);
        ?>
        <dl>
            <dt class="text-maroon">Hall Code</dt>
            <dd class="pl-4 font-weight-bold">
                <?php echo $hallDetails['code']; ?>
            </dd>
            <dt class="text-maroon">Hall Name</dt>
            <dd class="pl-4 font-weight-bold">
                <?php echo $hallDetails['name']; ?>
            </dd>
            <dt class="text-maroon">Hall Price</dt>
            <dd class="pl-4 font-weight-bold">
                <?php echo $hallDetails['price']; ?>
            </dd>
            <dt class="text-maroon">Description</dt>
            <dd class="pl-4 font-weight-bold">
                <?php echo $hallDetails['description']; ?>
            </dd>
            <dt class="text-maroon">Date Of Creation</dt>
            <dd class="pl-4 font-weight-bold">
                <?php echo $hallDetails['created_at']; ?>
            </dd>
            <dt class="text-maroon">Status</dt>
            <dd class="pl-4 font-weight-bold">
                <?php echo ($hallDetails['status'] == 1 ? 'Active' : 'Inactive'); ?>
            </dd>
            <dt class="text-maroon">Image</dt>
            <dd class="pl-4 font-weight-bold">
                <img src="<?php echo $hallDetails['image_path']; ?>" style="width: 100%;height: 50vh;" alt="">
            </dd>
            
            <!-- Add more details if needed -->
        </dl>
        <?php
    } else {
        echo 'Error: Failed to retrieve hall details';
    }
} else {
    echo 'Error: Invalid request';
}
?>