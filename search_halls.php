<?php
require_once('config.php');
require_once('functions.php');

if (isset($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($con, $_GET['search']);
    
    $query = "SELECT * FROM `halls` WHERE `status` = 1 AND `name` LIKE '%$searchQuery%'";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()):
            ?>
            <div class="col-sm-12 col-md-6 col-lg-6 hall-item">
                <a class="text-docoration-none text-reset view_hall" data-id="<?= $row['id'] ?>"
                    href="javascript:void(0)">
                    <div class="callout border-danger rounded-0 shadow">
                        <div class="d-flex align-items-center">
                            <div class="col-4 text-center">
                                <div class="hall-image-view-holder">
                                    <img src="admin<?= replaceRelativePath($row['image_path']) ?>" alt="Hall Image"
                                        class="img-fluid bg-gradient-gray hall-image-view">
                                </div>
                            </div>
                            <div class="col-8">
                                <h4><b><?= $row['name'] ?></b></h4>
                                <p class="truncate-3"><?= $row['description']; ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php
        endwhile;
    } else {
        echo "<center><span class='text-muted'>No matching hall found.</span></center>";
    }
}
?>