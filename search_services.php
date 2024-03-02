<?php
require_once('config.php');
require_once('functions.php');

if (isset($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($con, $_GET['search']);
    
    $query = "SELECT * FROM `services` WHERE `status` = 1 AND LOWER(`name`) LIKE '%$searchQuery%'";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()):
            ?>
            <div class="text-decoration-none list-group-item rounded-0 service-item">
                <a class="d-flex w-100 text-reset" href="#service_<?= $row['id'] ?>" data-toggle="collapse">
                    <div class="col-11">
                        <h3 class="truncate-1" title="<?= ucwords($row['name']) ?>"><b><?= ucwords($row['name']) ?></b></h3>
                    </div>
                    <div class="col-1 text-right">
                        <i class="fa fa-plus collapse-icon"></i>
                    </div>
                </a>
                <div class="collapse" id="service_<?= $row['id'] ?>">
                    <hr class="border-light">
                    <div class="mx-3"><?= html_entity_decode($row['description']) ?></div>
                </div>
            </div>
            <?php
        endwhile;
    } else {
        echo "<center><span class='text-muted'>No matching service found.</span></center>";
    }
}
?>