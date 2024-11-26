<?php if ($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
    </script>
<?php endif; ?>

<style>
    img#cimg {
        height: 300px; 
        width: 100%; 
        object-fit: cover;
        border-radius: 0; 
    }

    .table {
        width: 100%;
        margin-top: 20px;
    }

    .action-dropdown .dropdown-menu {
        min-width: 8rem;
    }

    .action-dropdown .dropdown-item i {
        margin-right: 5px;
    }
</style>

<div class="col-lg-12">
    <div class="card card-outline rounded-0 card-primary">
        <div class="card-header">
            <h5 class="card-title">Manage Officers</h5>
        </div>
        <div class="card-body">
            <!-- Form to Add/Edit Officers -->
            <form action="" id="officer-frm" method="POST" enctype="multipart/form-data">
                <div id="msg" class="form-group"></div>
                
                <div class="form-group">
                    <label for="firstname" class="control-label">First Name</label>
                    <input type="text" class="form-control form-control-sm" name="firstname" id="firstname" required>
                </div>

                <div class="form-group">
                    <label for="middlename" class="control-label">Middle Name</label>
                    <input type="text" class="form-control form-control-sm" name="middlename" id="middlename">
                </div>

                <div class="form-group">
                    <label for="lastname" class="control-label">Last Name</label>
                    <input type="text" class="form-control form-control-sm" name="lastname" id="lastname" required>
                </div>

                <div class="form-group">
                    <label for="position" class="control-label">Rank/Position</label>
                    <input type="text" class="form-control form-control-sm" name="position" id="position" required>
                </div>

                <div class="form-group">
                    <label for="officer_image" class="control-label">Officer Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="officer_image" name="officer_image" accept="image/*" onchange="displayImg(this,$(this))">
                        <label class="custom-file-label" for="officer_image">Choose file</label>
                    </div>
                </div>

                <div class="form-group d-flex justify-content-center">
                    <img src="" alt="" id="cimg" class="img-fluid img-thumbnail">
                </div>

                <button class="btn btn-sm btn-primary" type="submit">Save Officer</button>
            </form>
        </div>
    </div>
</div>

<!-- Officers List -->
<div class="col-lg-12">
    <div class="card card-outline rounded-0 card-primary mt-4">
        <div class="card-header">
            <h5 class="card-title">Officer List</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Full Name</th>
                        <th>Rank/Position</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qry = $conn->query("SELECT * FROM officers WHERE delete_flag = 0 ORDER BY lastname, firstname ASC");
                    $i = 1;
                    while ($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <img src="<?php echo validate_image($row['image']); ?>" alt="Officer Image" class="img-thumbnail" style="width: 50px; height: 50px;">
                        </td>
                        <td><?php echo $row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td>
                            <div class="dropdown action-dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <!-- Edit Button -->
                                    <a href="javascript:void(0)" class="dropdown-item edit-officer" data-id="<?php echo $row['id']; ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <!-- Delete Button -->
                                    <a href="javascript:void(0)" class="dropdown-item delete-officer" data-id="<?php echo $row['id']; ?>">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#cimg').attr('src', e.target.result);
                _this.siblings('.custom-file-label').html(input.files[0].name);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // AJAX Save Officer
    $('#officer-frm').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '../classes/Master.php?f=save_officer',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function() {
                start_loader();
            },
            success: function(resp) {
                if (resp.status == 'success') {
                    alert_toast("Officer successfully saved", 'success');
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                }
                end_loader();
            }
        });
    });

    // Delete Officer
    $('.delete-officer').click(function() {
        var id = $(this).attr('data-id');
        if (confirm("Are you sure to delete this officer?")) {
            $.ajax({
                url: '../classes/Master.php?f=delete_officer',
                method: 'POST',
                data: { id: id },
                success: function(resp) {
                    resp = JSON.parse(resp);
                    if (resp.status === 'success') {
                        alert_toast("Officer successfully deleted", 'success');
                        location.reload();
                    } else {
                        alert_toast("Failed to delete officer.", 'error');
                    }
                }
            });
        }
    });
</script>
