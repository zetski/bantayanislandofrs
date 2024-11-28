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
            <form action="" id="officers-frm" method="POST" enctype="multipart/form-data">
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
					<input type="text" class="form-control form-control-sm" name="officer_middlename" id="officer_middlename" placeholder="Enter officer's middle name">
				</div>
				<div class="form-group">
					<label for="officer_position" class="control-label">Position</label>
					<input type="text" class="form-control form-control-sm" name="officer_position" id="officer_position" placeholder="Enter officer's position">
				</div>
                <div class="form-group">
					<label for="officer_images" class="control-label">Officer Image</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="officer_images" name="officer_images[]" accept=".png,.jpg,.jpeg" onchange="previewOfficerImages(this)">
						<label class="custom-file-label" for="officer_images">Choose file</label>
					</div>
				</div>
                <div class="form-group d-flex justify-content-start flex-wrap" id="officer-images-preview"></div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" id="save-officer-btn">Save Officer</button>
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
		//officers function
		$('#officers-frm').submit(function (e) {
			e.preventDefault(); // Prevent default form submission

			// Client-side validation
			let valid = true;
			const requiredFields = ['#officer_lastname', '#officer_firstname', '#officer_middlename', '#officer_position'];
			requiredFields.forEach(function (selector) {
				const field = $(selector);
				if (field.val().trim() === '') {
					field.addClass('is-invalid'); // Highlight the field with an error
					valid = false;
				} else {
					field.removeClass('is-invalid'); // Remove error highlight
				}
			});

			if (!valid) {
				Swal.fire({
					icon: 'error',
					title: 'Validation Error',
					text: 'Please fill in all required fields.',
				});
				return; // Exit function if validation fails
			}

			// Proceed with the AJAX request if validation passes
			Swal.fire({
				title: 'Saving Officer...',
				text: 'Please wait while we process your request.',
				allowOutsideClick: false,
				didOpen: () => {
					Swal.showLoading(); // Show loading spinner
				}
			});

			var formData = new FormData(this);

			$.ajax({
				url: '../classes/Master.php?f=save_officer',
				method: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function (resp) {
					Swal.close(); // Close the loading spinner
					try {
						var response = JSON.parse(resp); // Parse the response
						if (response.status === "success") {
							Swal.fire({
								icon: 'success',
								title: 'Officer Saved',
								text: 'The officer has been successfully saved!',
								confirmButtonText: 'OK', // Show OK button
								showConfirmButton: true // Ensure the button is visible
							}).then(() => {
								$('#officers-frm')[0].reset();
								loadOfficers(); // Reset the form

								// Dynamically add the new officer to the table
								var newRow = `
									<tr id="officer-row-${response.id}">
										<td>${response.id}</td>
										<td>${response.lastname} ${response.firstname} ${response.middlename}</td>
										<td>${response.position}</td>
										<td><img src="${response.image}" alt="Officer Image" class="img-thumbnail" width="50" height="50"></td>
										<td>
											<button class="btn btn-sm btn-primary" onclick="edit_officer(${response.id})">
												<i class="fa fa-edit"></i> Edit
											</button>
											<button class="btn btn-sm btn-danger" onclick="delete_officer(${response.id})">
												<i class="fa fa-trash"></i> Delete
											</button>
										</td>
									</tr>
								`;
								$('#officers-table tbody').append(newRow); // Append to the table
							});
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Save Failed',
								text: response.error || 'An error occurred while saving the officer.',
							});
						}
					} catch (err) {
						console.error("Response parsing failed:", err, resp);
						Swal.fire({
							icon: 'error',
							title: 'Unexpected Error',
							text: 'The server returned an invalid response. Please check the console for details.',
						});
					}
				},
				error: function (xhr, status, error) {
					Swal.close(); // Close the loading spinner
					console.error("AJAX Error:", status, error, xhr.responseText);
					Swal.fire({
						icon: 'error',
						title: 'Submission Failed',
						text: 'An error occurred during submission.',
					});
				}
			});
		});


		// Dynamically load officers (optional if needed)
		function loadOfficers() {
			$.ajax({
				url: '../classes/Master.php?f=get_officers',
				method: 'GET',
				success: function (resp) {
					try {
						const data = JSON.parse(resp);
						if (data.status === 'success') {
							let tableRows = '';
							data.officers.forEach(officer => {
								tableRows += `
									<tr id="officer-row-${officer.id}">
										<td>${officer.id}</td>
										<td>${officer.lastname} ${officer.firstname} ${officer.middlename}</td>
										<td>${officer.position}</td>
										<td><img src="${officer.image}" alt="Officer Image" class="img-thumbnail" width="50" height="50"></td>
										<td>
											<button class="btn btn-sm btn-danger" onclick="delete_officer(${officer.id})">
												<i class="fa fa-trash"></i> Delete
											</button>
										</td>
									</tr>
								`;
							});
							$('#officers-table tbody').html(tableRows); // Update the table body
						} else {
							$('#officers-table tbody').html('<tr><td colspan="5" class="text-center">No officers found.</td></tr>');
						}
					} catch (err) {
						console.error('Error parsing officers data:', err, resp);
						$('#officers-table tbody').html('<tr><td colspan="5" class="text-center">Error loading data.</td></tr>');
					}
				},
				error: function (xhr, status, error) {
					console.error('Failed to fetch officers:', error);
					$('#officers-table tbody').html('<tr><td colspan="5" class="text-center">Failed to load data.</td></tr>');
				}
			});
		}

		// Call this function on page load
		$(document).ready(function () {
			loadOfficers();
		});

		function delete_officer(id) {
			Swal.fire({
				title: 'Are you sure?',
				text: "This action cannot be undone!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire({
						title: 'Deleting Officer...',
						allowOutsideClick: false,
						didOpen: () => {
							Swal.showLoading(); // Show loading spinner
						}
					});

					$.ajax({
						url: '../classes/Master.php?f=delete_officer',
						method: 'POST',
						data: { id: id },
						dataType: 'json',
						success: function (resp) {
							if (resp.status === 'success') {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: 'The officer has been successfully deleted.',
									confirmButtonText: 'OK', // Show the OK button
									showConfirmButton: true // Ensure button is visible
								}).then(() => {
									$('#officer-row-' + id).fadeOut('slow', function () {
										$(this).remove();
									});
								});
							} else {
								Swal.fire({
									icon: 'error',
									title: 'Delete Failed',
									text: resp.error || 'An error occurred while deleting the officer.',
								});
							}
						},
						error: function (xhr, status, error) {
							console.error("AJAX Error:", status, error, xhr.responseText);
							Swal.fire({
								icon: 'error',
								title: 'Deletion Failed',
								text: 'An error occurred during the deletion process.',
							});
						}
					});
				}
			});
		}

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
		// end of officers code

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
        url: _base_url_ + '../classes/Master.php?f=delete_img',
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
