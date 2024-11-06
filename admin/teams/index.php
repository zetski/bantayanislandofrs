<?php
// Check if a success message is set
if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif;?>

<style>
	.team-logo{
		width: 3em;
		height: 3em;
		object-fit: cover;
		object-position: center center;
	}
</style>

<div class="card card-outline rounded-0 card-danger">
	<div class="card-header">
		<h3 class="card-title">List of Teams</h3>
		<div class="card-tools">
			<a href="./?page=teams/manage_team" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="10%">
					<col width="10%">
					<col width="20%">
					<col width="25%">
					<col width="15%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Code</th>
						<th>District</th>
						<th>Team Leader</th>
						<th>Members</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;

					// Get the current admin's district from the session or logged-in user data
					$current_admin_district = $_settings->userdata('district'); // Assuming 'district' is stored in user session data

					// Modify the query to select teams only from the current admin's district
					$qry = $conn->query("SELECT *, COALESCE((SELECT `status` FROM `request_list` WHERE `team_id` = team_list.id AND `status` IN (1,2,3)), 0) AS `status` FROM `team_list` WHERE `district` = '{$current_admin_district}' AND delete_flag = 0 ORDER BY `code` ASC");

					while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
							<td class=""><?= $row['code'] ?></td>
							<td class=""><?= $row['district'] ?></td>
							<td>
								<div style="line-height:1em">
									<div class="font-weight-bold"><?= $row['leader_name'] ?></div>
									<div><?= $row['leader_contact'] ?></div>
								</div>
							</td>
							<td><p class="mb-0 truncate-1"><?php echo ($row['members']) ?></p></td>
							<td class="text-center">
                                <?php if($row['status'] == 0): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Available</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Unavailable</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								<button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
									Action
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" href="./?page=teams/view_team&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="./?page=teams/manage_team&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-footer text-right">
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			var id = $(this).attr('data-id');
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
					delete_team(id);
				}
			});
		});

		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [2, 6] }
			],
			order: [0, 'asc']
		});

		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle');
	});

	function delete_team(id){
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_team",
			method: "POST",
			data: {id: id},
			dataType: "json",
			error: err => {
				console.log(err);
				alert_toast("An error occurred.", 'error');
				end_loader();
			},
			success: function(resp){
				if(typeof resp == 'object' && resp.status == 'success'){
					location.reload();
				} else {
					alert_toast("An error occurred.", 'error');
					end_loader();
				}
			}
		});
	}
</script>
