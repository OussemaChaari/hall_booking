<?php
require_once('config.php');
require_once('functions.php');

?>
<!DOCTYPE html>
<html lang="en">
<style>
    .hall-image-view-holder {
        width: 100%;
        height: 10em;
        overflow: hidden;
    }

    .hall-image-view {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        transition: transform .2s ease-in;
    }

    .hall-item:hover .hall-image-view {
        transform: scale(1.2)
    }

    .content-wrapper {
        margin-top: calc(1.8rem + 1px) !important;
    }
</style>
<div class="content py-5">
    <h3 class="text-center"><b>Our Halls</b></h3>
    <hr class="w-25 border-light">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="input-group mb-2">
                <input type="search" id="search" class="form-control form-control-border"
                    placeholder="Search hall here...">
               
            </div>
        </div>
    </div>
    <div class="row justify-content-center" id="hall-list">
        <?php
        $halls = $con->query("SELECT * FROM `halls` where `status` = 1");
        while ($row = $halls->fetch_assoc()):
            ?>
            <div class="col-sm-12 col-md-6 col-lg-6 hall-item">
                <a class="text-docoration-none text-reset view_hall" data-id="<?= $row['id'] ?>" href="javascript:void(0)">
                    <div class="callout border-danger rounded-0 shadow">
                        <div class="d-flex align-items-center">
                            <div class="col-4 text-center">
                                <div class="hall-image-view-holder">
                                    <img src="admin<?= replaceRelativePath($row['image_path']) ?>" alt="Hall Image"
                                        class="img-fluid bg-gradient-gray hall-image-view">
                                </div>
                            </div>
                            <div class="col-8">
                                <h4><b>
                                        <?= $row['name'] ?>
                                    </b></h4>
                                <p class="truncate-3">
                                    <?= $row['description']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
    <?php if ($halls->num_rows < 1): ?>
        <center><span class="text-muted">No hall Listed Yet.</span></center>
    <?php endif; ?>
    <div id="no_result" style="display:none">
        <center><span class="text-muted">No hall Listed Yet.</span></center>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#search').on('input', function () {
            var searchQuery = $(this).val();

            $.ajax({
                url: 'search_halls.php',
                type: 'GET',
                data: { search: searchQuery },
                success: function (response) {
                    $('#hall-list').html(response);
                    if ($('#hall-list').children().length === 0) {
                        $('#no_result').show();
                    } else {
                        $('#no_result').hide();
                    }
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        });
    });
</script>