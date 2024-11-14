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
					<!-- Officers Edit Section -->
					<div class="card card-outline rounded-0 card-info mt-4">
						<div class="card-header">
							<h5 class="card-title">Edit Officers</h5>
						</div>
						<div class="card-body">
							<!-- Officer Name Input -->
							<div class="form-group">
								<label for="officer_name" class="control-label">Officer Name</label>
								<input type="text" class="form-control form-control-sm" name="officer_name" id="officer_name" placeholder="Enter officer's full name">
							</div>
							
							<!-- Officer Position Input -->
							<div class="form-group">
								<label for="officer_position" class="control-label">Position</label>
								<input type="text" class="form-control form-control-sm" name="officer_position" id="officer_position" placeholder="Enter officer's position">
							</div>
							
							<!-- Officer Image Upload -->
							<div class="form-group">
								<label for="officer_image" class="control-label">Officer Image</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="officer_image" name="officer_image" onchange="displayOfficerImg(this, $(this))">
									<label class="custom-file-label" for="officer_image">Choose file</label>
								</div>
							</div>
							
							<!-- Officer Image Preview -->
							<div class="form-group d-flex justify-content-center">
								<img src="#" alt="Officer Image Preview" id="officer_img_preview" class="img-fluid img-thumbnail" style="height: 15vh; width: 15vh; object-fit: cover; border-radius: 100%;">
							</div>
						</div>
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
									<!-- District Logo Input -->
					<!-- <div class="form-group">
						<label for="" class="control-label">District Logo</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input rounded-circle" id="districtLogoInput" name="district_logo" onchange="displayDistrictLogo(this,$(this))">
							<label class="custom-file-label" for="districtLogoInput">Choose file</label>
						</div>
					</div>
						<div class="form-group d-flex justify-content-center">
						<img src="</?php echo validate_image($_settings->info('district_logo')) ?>" alt="" id="districtLogo" class="img-fluid img-thumbnail">
					</div>
					 -->
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

	<script>
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

		function delete_img(path){
			start_loader();
			$.ajax({
				url: _base_url_+'classes/Master.php?f=delete_img',
				data:{path:path},
				method:'POST',
				dataType:"json",
				error:err=>{
					console.log(err);
					alert_toast("An error occurred while deleting an Image","error");
					end_loader();
				},
				success:function(resp){
					$('.modal').modal('hide');
					if(typeof resp =='object' && resp.status == 'success'){
						$('[data-path="'+path+'"]').closest('.img-item').hide('slow',function(){
							$('[data-path="'+path+'"]').closest('.img-item').remove();
						});
						alert_toast("Image Successfully Deleted","success");
					}else{
						console.log(resp);
						alert_toast("An error occurred while deleting an Image","error");
					}
					end_loader();
				}
			});
		}

		$(document).ready(function(){
			$('.rem_img').click(function(){
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