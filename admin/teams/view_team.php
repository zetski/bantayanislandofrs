<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT *,COALESCE((SELECT `status` FROM `request_list` where `team_id` = team_list.id and `status` in (1,2,3)), 0) as `status` from `team_list` where id = '{$_GET['id']}' and delete_flag = 0 ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="content py-3 px-3" style="background-color: #ff4600; color: #fff">
	<h2><b>Team Details</b></h2>
</div>
<div class="row mt-lg-n4 mt-md-n4 justify-content-center">
	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
		<div class="card rounded-0">
			<div class="card-body">
                <div class="container-fluid">
                    <dl>
                        <dt class="text-muted">Code.</dt>
                        <dd class="pl-4"><?= isset($code) ? $code : "" ?></dd>
						<dt class="text-muted">District.</dt>
						<dd class="pl-4"><?= isset ($district) ? $district: "" ?></dd>
                        <dt class="text-muted">TL Name</dt>
                        <dd class="pl-4"><?= isset($leader_name) ? $leader_name : "" ?></dd>
                        <dt class="text-muted">TL Contact #</dt>
                        <dd class="pl-4"><?= isset($leader_contact) ? $leader_contact : "" ?></dd>
                        <dt class="text-muted">Members</dt>
                        <dd class="pl-4"><?= isset($members) ? str_replace(["\n\r", "\n", "\r"],"<br>", $members) : '' ?></dd>
                        <dt class="text-muted">Status</dt>
                        <dd class="pl-4">
                            <?php if($status == 0): ?>
                                <span class="badge badge-success px-3 rounded-pill">Available</span>
                            <?php else: ?>
                                <span class="badge badge-danger px-3 rounded-pill">Unavailable</span>
                            <?php endif; ?>
                        </dd>
                    </dl>
                </div>
            </div>
			<div class="card-footer py-1 text-center">
				<!-- swap position DELETE AND EDIT -->
			<!-- <a class="btn btn-primary btn-sm bg-gradient-primary rounded-0" href="./?page=teams/manage_team&id=</?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Edit</a>
				<button class="btn btn-danger btn-sm bg-gradient-danger rounded-0" type="button" id="delete_data"><i class="fa fa-trash"></i> Delete</button> -->
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=teams"><i class="fa fa-angle-left"></i> Back to List</a>
			</div>
		</div>
	</div>
</div>
<script>
    $(function(){
		$('#delete_data').click(function(){
			_conf("Are you sure to delete this Team permanently?","delete_team", ["<?= isset($id) ? $id :'' ?>"])
		})
    })
    function delete_team($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_team",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace("./?page=teams");
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>