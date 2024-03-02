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
                        <h5 class="card-title">System Information</h5>
                    </div>
                    <form action="" method="post" id="general_info" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="etat" class="control-label">Etat System</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="etatSwitch" name="etat"
                                        value="">
                                    <label class="custom-control-label" for="etatSwitch"></label>
                                    <input type="hidden" name="etat" value="">
                                </div>
                                <p id="etatDescription"></p>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">System Name</label>
                                <input type="text" id="name_system" class="form-control form-control-sm" required>
                            </div>
                            <div class="form-group">
                                <label for="short_name" class="control-label">System Short Name</label>
                                <input type="text" class="form-control form-control-sm" name="short_name"
                                    id="short_name" required>
                            </div>
                            <div class="form-group">
                                <label for="content[about_us]" class="control-label">Welcome Content</label>
                                <textarea type="text" class="form-control form-control-sm summernote"
                                    name="content[welcome]" id="welcome"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="content[about_us]" class="control-label">About Us</label>
                                <textarea type="text" class="form-control form-control-sm summernote"
                                    name="content[about_us]" id="about_us"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="customFile">Logo</label>
                                <img src="" id="system_logo" alt="Logo Preview"
                                    style="max-width: 100px; max-height: 100px;" name="logo">
                                <input type="file" class="form-control" id="logo_input"
                                    onchange="previewImage('logo_input', 'system_logo')" name="logo">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="customFile">Cover</label>
                                <img src="" id="cover_system" alt="Cover Preview"
                                    style="max-width: 100px; max-height: 100px;" name="cover">
                                <input type="file" class="form-control" id="cover_input"
                                    onchange="previewImage('cover_input', 'cover_system')" name="cover">
                            </div>

                            <fieldset>
                                <legend>Other Information</legend>
                                <div class="form-group">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="email" class="form-control form-control-sm" id="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="contact" class="control-label">Contact</label>
                                    <input type="text" class="form-control form-control-sm" id="contact" required>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="control-label">Office Address</label>
                                    <textarea rows="3" class="form-control form-control-sm" id="address"
                                        style="resize:none" required></textarea>
                                </div>
                            </fieldset>
                        </div>
                        <div class="card-footer">
                            <div class="col-md-12">
                                <div class="row">
                                    <button type="submit" name="update_settings"
                                        class="btn btn-sm btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
    <script>

        document.getElementById('etatSwitch').addEventListener('change', function () {
            var etatDescription = document.getElementById('etatDescription');
            if (this.checked) {
                etatDescription.innerText = 'Le système est actif.';
            } else {
                etatDescription.innerText = 'Le système est inactif.';
            }
        });
        function previewImage(inputId, imgId) {
            let input = document.getElementById(inputId);
            let img = document.getElementById(imgId);
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        let general_info = document.getElementById('general_info');
        var etatDescription = document.getElementById('etatDescription');

        function get_general() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../ajax/settings_info.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    let general_data = JSON.parse(xhr.responseText);
                    $("#name_system").val(general_data.name);
                    $("#short_name").val(general_data.short_name);
                    $('#welcome').summernote('code', general_data.welcome_content);
                    $('#about_us').summernote('code', general_data.about_us_content);
                    $("#system_logo").attr("src", general_data.system_logo);
                    $("#cover_system").attr("src", general_data.cover_image);
                    $("#email").val(general_data.email);
                    $("#contact").val(general_data.contact_number);
                    $("#address").val(general_data.office_address);
                    etatSwitch.checked = (general_data.shutdown == 1);
                    if (general_data.shutdown == 1) {
                        etatDescription.innerText = 'Le système est actif.';
                    } else {
                        etatDescription.innerText = 'Le système est inactif.';
                    }
                } else {
                    showAlert('error', 'Failed to retrieve general information');
                }
            };
            xhr.send('get_general=1');
        }
        general_info.addEventListener('submit', function (e) {
            e.preventDefault();
            upd_general();
        });
        function upd_general() {
            let etatSwitchValue = document.getElementById('etatSwitch').checked ? 1 : 0;
            let nameSystemValue = document.getElementById('name_system').value;
            let shortNameValue = document.getElementById('short_name').value;
            let welcomeContentValue = $('#welcome').summernote('code');
            let aboutUsContentValue = $('#about_us').summernote('code');
            let emailValue = document.getElementById('email').value;
            let contactValue = document.getElementById('contact').value;
            let addressValue = document.getElementById('address').value;
            let logoFileInput = document.getElementById('logo_input');
            let coverFileInput = document.getElementById('cover_input');
            let logoFile = logoFileInput.files[0];
            let coverFile = coverFileInput.files[0];

            let formData = new FormData();
            formData.append('update_settings', 1);
            formData.append('etat', etatSwitchValue);
            formData.append('name', nameSystemValue);
            formData.append('short_name', shortNameValue);
            formData.append('welcome_content', welcomeContentValue);
            formData.append('about_us_content', aboutUsContentValue);
            formData.append('email', emailValue);
            formData.append('contact', contactValue);
            formData.append('address', addressValue);
            if (logoFile) {
                formData.append('logo', logoFile);
            }
            if (coverFile) {
                formData.append('cover', coverFile);
            }
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../ajax/settings_info.php", true);
            xhr.onload = function () {
                if (this.responseText == 1) {
                    get_general();
                    console.log('yes');
                    showAlert('success', 'Data updated successfully');
                } else {
                    console.log('no');
                    showAlert('error', 'Failed to update data');
                }
            };
            xhr.send(formData);
        }

        $(document).ready(function () {
            $('.summernote').summernote({
                height: '60vh',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ol', 'ul', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ]
            })
        })
        window.onload = function () {
            get_general();
        }
        
    </script>
        <script src="<?php echo base_url ?>dist/js/global.js"></script>


</body>

</html>