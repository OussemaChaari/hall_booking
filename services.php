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
<h3 class="text-center"><b>Our Services</b></h3>
<hr class="w-25 border-light">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="input-group mb-2">
                <input type="search" id="search" class="form-control form-control-border"
                    placeholder="Search service here...">

            </div>
        </div>
    </div>
    <div class="list-group" id="service-list">
        <?php
        $service = $con->query("SELECT * FROM `services` where `status` = 1");
        while ($row = $service->fetch_assoc()):
            ?>
            <div class="text-decoration-none list-group-item rounded-0 service-item">
                <a class="d-flex w-100 text-reset" href="#service_<?= $row['id'] ?>" data-toggle="collapse">
                    <div class="col-11">
                        <h3 class="truncate-1" title="<?= ucwords($row['name']) ?>"><b>
                                <?= ucwords($row['name']) ?>
                            </b></h3>
                    </div>
                    <div class="col-1 text-right">
                        <i class="fa fa-plus collapse-icon"></i>
                    </div>
                </a>
                <div class="collapse" id="service_<?= $row['id'] ?>">
                    <hr class="border-light">
                    <div class="mx-3">
                        <?= html_entity_decode($row['description']) ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        <?php if ($service->num_rows < 1): ?>
            <center><span class="text-muted">No service Listed Yet.</span></center>
        <?php endif; ?>
        <div id="no_result" style="display:none">
            <center><span class="text-muted">No service Listed Yet.</span></center>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#search').on('input', function () {
            var searchQuery = $(this).val();

            $.ajax({
                url: 'search_services.php',
                type: 'GET',
                data: { search: searchQuery },
                success: function (response) {
                    $('#service-list').html(response);
                    if ($('#service-list .service-item:visible').length === 0) {
                        $('#no_result').show('slow');
                    } else {
                        $('#no_result').hide('slow');
                    }
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        });
    });
    $(function () {
        $('.collapse').on('show.bs.collapse', function () {
            $(this).parent().siblings().find('.collapse').collapse('hide')
            $(this).parent().siblings().find('.collapse-icon').removeClass('fa-plus fa-minus')
            $(this).parent().siblings().find('.collapse-icon').addClass('fa-plus')
            $(this).parent().find('.collapse-icon').removeClass('fa-plus fa-minus')
            $(this).parent().find('.collapse-icon').addClass('fa-minus')
        })
        $('.collapse').on('hidden.bs.collapse', function () {
            $(this).parent().find('.collapse-icon').removeClass('fa-plus fa-minus')
            $(this).parent().find('.collapse-icon').addClass('fa-plus')
        })

        $('#search').on("input", function (e) {
            var _search = $(this).val().toLowerCase()
            $('#service-list .service-item').each(function () {
                var _txt = $(this).text().toLowerCase()
                if (_txt.includes(_search) === true) {
                    $(this).toggle(true)
                } else {
                    $(this).toggle(false)
                }
                if ($('#service-list .service-item:visible').length <= 0) {
                    $("#no_result").show('slow')
                } else {
                    $("#no_result").hide('slow')
                }
            })
        })
    })
</script>