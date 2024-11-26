	<?php if($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>",'success');
	</script>
	<?php endif;?>

	<style>
		img#cimg{
			height: 15vh;
			width: 15vh;
			object-fit: cover;
			border-radius: 100% 100%;
		}
		img#cimg2{
			height: 50vh;
			width: 100%;
			object-fit: contain;
			/* border-radius: 100% 100%; */
		}
		img#districtLogo{
			height: 15vh;
			width: 15vh;
			object-fit: cover;
			border-radius: 100% 100%;
		}
	</style>

	<div class="col-lg-12">
		<div class="card card-outline rounded-0 card-danger">
			<div class="card-header">
				<h5 class="card-title">System Information</h5>
			</div>
			<div class="card-body">
				<form action="" id="system-frm">
					<div id="msg" class="form-group"></div>
					<div class="form-group">
						<label for="name" class="control-label">System Name</label>
						<input type="text" class="form-control form-control-sm" name="name" id="name" value="<?php echo $_settings->info('name') ?>">
					</div>
					<div class="form-group">
						<label for="short_name" class="control-label">System Short Name</label>
						<input type="text" class="form-control form-control-sm" name="short_name" id="short_name" value="<?php echo  $_settings->info('short_name') ?>">
					</div>
					<div class="form-group">
						<label for="" class="control-label">Welcome Content</label>
						<textarea name="content[welcome]" id="" cols="30" rows="2" class="form-control summernote"><?php echo  is_file(base_app.'welcome.html') ? file_get_contents(base_app.'welcome.html') : "" ?></textarea>
					</div>
					<div class="form-group">
						<label for="" class="control-label">System Logo</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input rounded-circle" id="customFile1" name="img" onchange="displayImg(this,$(this))">
							<label class="custom-file-label" for="customFile1">Choose file</label>
						</div>
					</div>
					<div class="form-group d-flex justify-content-center">
						<img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
					</div>
					<div class="form-group">
						<label for="" class="control-label">Website Cover</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input rounded-circle" id="customFile2" name="cover" onchange="displayImg2(this,$(this))">
							<label class="custom-file-label" for="customFile2">Choose file</label>
						</div>
					</div>
					<div class="form-group d-flex justify-content-center">
						<img src="<?php echo validate_image($_settings->info('cover')) ?>" alt="" id="cimg2" class="img-fluid img-thumbnail">
					</div>
					<div class="form-group">
						<label for="" class="control-label">Banner Images</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input rounded-circle" id="customFile3" name="banners[]" multiple accept=".png,.jpg,.jpeg" onchange="displayImg3(this,$(this))">
							<label class="custom-file-label" for="customFile3">Choose file</label>
						</div>
						<small><i>Choose to upload new banner images</i></small>
					</div>
					
					<?php 
					$upload_path = "uploads/banner";
					if(is_dir(base_app.$upload_path)): 
						$file= scandir(base_app.$upload_path);
						foreach($file as $img):
							if(in_array($img,array('.','..')))
								continue;
					?>
					<div class="d-flex w-100 align-items-center img-item">
						<span><img src="<?php echo base_url.$upload_path.'/'.$img."?v=".(time()) ?>" width="150px" height="100px" style="object-fit:cover;" class="img-thumbnail" alt=""></span>
						<span class="ml-4"><button class="btn btn-sm btn-default text-danger rem_img" type="button" data-path="<?php echo base_app.$upload_path.'/'.$img ?>"><i class="fa fa-trash"></i></button></span>
					</div>
					<?php endforeach; ?>
					<?php endif; ?>
	<br>
									
				</form>
			</div>
			<div class="card-footer">
				<div class="col-md-12">
					<div class="row">
						<button class="btn btn-sm btn-primary" form="system-frm">Update</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	 <!-- Officers Management Section -->
	 <div class="card card-outline rounded-0 card-danger mt-3">
        <div class="card-header">
            <h5 class="card-title">Officers Management</h5>
        </div>
        <div class="card-body">
            <form action="" id="officers-frm" enctype="multipart/form-data">
                <div id="officers-msg" class="form-group"></div>
                <div class="form-group">
					<label for="officer_lastname" class="control-label">Last Name</label>
					<input type="text" class="form-control form-control-sm" name="officer_lastname" id="officer_lastname" placeholder="Enter officer's last name">
				</div>
				<div class="form-group">
					<label for="officer_firstname" class="control-label">First Name</label>
					<input type="text" class="form-control form-control-sm" name="officer_firstname" id="officer_firstname" placeholder="Enter officer's first name">
				</div>
				<div class="form-group">
					<label for="officer_middlename" class="control-label">Middle Name</label>
					<input type="text" class="form-control form-control-sm" name="officer_middlename" id="officer_middlename" placeholder="Enter officer's middle name (optional)">
				</div>
				<div class="form-group">
					<label for="officer_position" class="control-label">Position</label>
					<input type="text" class="form-control form-control-sm" name="officer_position" id="officer_position" placeholder="Enter officer's position">
				</div>
                <div class="form-group">
                    <label for="officer_images" class="control-label">Officer Images</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="officer_images" name="officer_images[]" multiple accept=".png,.jpg,.jpeg" onchange="previewOfficerImages(this)">
                        <label class="custom-file-label" for="officer_images">Choose files</label>
                    </div>
                </div>
                <div class="form-group d-flex justify-content-start flex-wrap" id="officer-images-preview"></div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Save Officer</button>
                </div>
            </form>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="officers-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Images</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Officers data will be loaded here dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

	<script>
		function loadOfficers() {
    $.ajax({
        url: 'classes/Master.php?action=get_officers',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            let tableBody = $('#officersTable tbody');
            tableBody.empty(); // Clear existing rows
            response.forEach(officer => {
                tableBody.append(`
                    <tr>
                        <td>${officer.name}</td>
                        <td>${officer.position}</td>
                        <td><img src="${officer.image}" alt="Officer Image" height="50"></td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-officer" data-id="${officer.id}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-officer" data-id="${officer.id}">Delete</button>
                        </td>
                    </tr>
                `);
            });
        }
    });
}
$('#saveOfficerForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: 'classes/Master.php?action=save_officer',
        method: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert(response.msg);
                loadOfficers(); // Reload table
                $('#officerModal').modal('hide'); // Close modal
            } else {
                alert(response.msg);
            }
        }
    });
});
		function previewOfficerImages(input) {
        const previewContainer = $('#officer-images-preview');
        previewContainer.html(''); // Clear previous previews
        if (input.files) {
            Array.from(input.files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = $('<img>')
                        .attr('src', e.target.result)
                        .css({ width: '100px', height: '100px', objectFit: 'cover', margin: '5px' })
                        .addClass('img-thumbnail');
                    previewContainer.append(img);
                };
                reader.readAsDataURL(file);
            });
        }
    }

		function displayImg(input,_this) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#cimg').attr('src', e.target.result);
					_this.siblings('.custom-file-label').html(input.files[0].name);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

		function displayImg2(input,_this) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					_this.siblings('.custom-file-label').html(input.files[0].name);
					$('#cimg2').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

		function displayDistrictLogo(input,_this) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#districtLogo').attr('src', e.target.result);
					_this.siblings('.custom-file-label').html(input.files[0].name);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

		function displayImg3(input,_this) {
			var fnames = [];
			Object.keys(input.files).map(function(k){
				fnames.push(input.files[k].name);
			});
			_this.siblings('.custom-file-label').html(fnames.join(", "));
		}

		function delete_img(path) {
    start_loader();
    $.ajax({
        url: _base_url_ + 'classes/Master.php?f=delete_img',
        data: { path: path },
        method: 'POST',
        dataType: "json",
        error: err => {
            console.log(err);
            Swal.fire("Error", "An error occurred while deleting the image.", "error");
            end_loader();
        },
        success: function (resp) {
            $('.modal').modal('hide');
            if (typeof resp == 'object' && resp.status == 'success') {
                $('[data-path="' + path + '"]').closest('.img-item').hide('slow', function () {
                    $('[data-path="' + path + '"]').closest('.img-item').remove();
                });
                Swal.fire("Image Successfully Deleted", "", "success");
            } else {
                console.log(resp);
                Swal.fire("Error", "An error occurred while deleting the image.", "error");
            }
            end_loader();
        }
    });
}

$(document).ready(function () {
    $('.rem_img').click(function () {
        var path = $(this).attr('data-path');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                delete_img(path);
            }
        });
    });

    $('.summernote').summernote({
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ol', 'ul', 'paragraph', 'height']],
            ['table', ['table']],
            ['view', ['undo', 'redo', 'fullscreen', 'help']]
        ]
    });
});
	</script>