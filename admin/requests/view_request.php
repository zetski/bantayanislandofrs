<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `request_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
    if(isset($team_id) && $team_id > 0){
        $team_qry = $conn->query("SELECT * FROM `team_list` where id = '{$team_id}'");
        if($team_qry->num_rows > 0){
            $res = $team_qry->fetch_array();
            foreach($res as $k => $v){
                if(!is_numeric($k)){
                    $team[$k] = $v;
                }
            }
        }
    }
}
?>
<style>
    #request-logo{
        max-width:100%;
        max-height: 20em;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="content py-3 px-3" style="background-color: #ff4600; color: #fff">
    <h2><b><?= isset($code) ? $code : '' ?> Request</b></h2>
</div>
<div class="row flex-column mt-lg-n4 mt-md-n4 justify-content-center align-items-center">
    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
        <div class="card rounded-0">
            <div class="card-header py-1">
            <div class="card-tools">
                <?php if(isset($status) && $status < 4 && isset($team_id) && $team_id > 0): ?>
                    <button class="btn btn-info btn-sm bg-gradient-info rounded-0" type="button" id="update_status">Update Status</button>
                <?php endif; ?>
                <!-- Show the print button only if the status is 4 (Completed) -->
                <?php if(isset($status) && $status == 4): ?>
                    <button class="btn btn-navy btn-sm bg-gradient-navy rounded-0" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                <?php endif; ?>
                <a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=requests"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 printout">
        <div class="card rounded-0">
            <div class="card-header py-1">
                <div class="card-title">Request Details</div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Request Code:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($code) ? $code : '' ?></div>
                    </div>
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Request Date&Time:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($date_created) ? date('M d, Y h:i A', strtotime($date_created)) : '' ?></div>
                    </div>
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Lastname:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($lastname) ? $lastname : '' ?></div>
                    </div>
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Firstname:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($firstname) ? $firstname : '' ?></div>
                    </div>
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Middlename:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($middlename) ? $middlename : '' ?></div>
                    </div>
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Contact #:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($contact) ? $contact : '' ?></div>
                    </div>
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Subject:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($subject) ? $subject : '' ?></div>
                    </div>
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Message:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($message) ? str_replace(["\r\n", "\r", "\n"], '<br>', $message) : '' ?></div>
                    </div>
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Municipality:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($municipality) ? str_replace(["\r\n", "\r", "\n"], '<br>', $municipality) : '' ?></div>
                    </div>
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Barangay:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($barangay) ? $barangay : '' ?></div>
                    </div>
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Purok/Street:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($sitio_street) ? $sitio_street : '' ?></div>
                    </div>
                </div>
            </div>
		</div>
	</div>
    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 printout">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="card-title">Assigned Team Details</div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <?php if(isset($team_id) && $team_id > 0): ?>
                        <div class="d-flex w-100 mb-2">
                            <div class="col-auto pr-1">Team Code:</div>
                            <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($team['code']) ? $team['code'] : '' ?></div>
                        </div>
                        <div class="d-flex w-100 mb-2">
                            <div class="col-auto pr-1">Team Leader:</div>
                            <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($team['leader_name']) ? $team['leader_name'] : '' ?></div>
                        </div>
                        <div class="d-flex w-100 mb-2">
                            <div class="col-auto pr-1">Team Leader Contact #:</div>
                            <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($team['leader_contact']) ? $team['leader_contact'] : '' ?></div>
                        </div>
                        <div class="d-flex w-100 mb-2">
                            <div class="col-auto pr-1">Team Members:</div>
                            <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($team['members']) ? str_replace(["\r\n", "\r", "\n"], '<br>', $team['members']) : '' ?></div>
                        </div>
                    <?php else: ?>
                        <h4 class="text-center">There's no team assigned to this request yet.</h4>
                        <div class="text-center">
                            <button class="btn btn-flat btn-sm btn-light bg-gradient-light border" type="button" id="assign_team"><i class="fa fa-users"></i> Assign a Team</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 printout">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="card-title">Action History</div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <table class="table table-bordered">
                        <colgroup>
                            <col width="25%">
                            <col width="30%">
                            <col width="45%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="px-1 py-1 text-center">Date Action Taken</th>
                                <th class="px-1 py-1 text-center">Status</th>
                                <th class="px-1 py-1 text-center">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(isset($id)):
                            $history = $conn->query("SELECT * FROM `history_list` where request_id = '{$id}' order by abs(unix_timestamp(date_created)) asc");
                            while($row = $history->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="px-1 py-1"><?= date("M d, Y h:i A", strtotime($row['date_created'])) ?></td>
                                <td class="px-1 py-1">
                                    <?php 
                                    switch($row['status']){
                                        case 0:
                                            echo 'Pending';
                                            break;
                                        case 1:
                                            echo 'Assigned to Team';
                                            break;
                                        case 2:
                                            echo 'Team is on their way';
                                            break;
                                        case 3:
                                            echo 'Relief on Progress';
                                            break;
                                        case 4:
                                            echo 'Relief Completed';
                                            break;
                                        default:
                                            echo 'N/A';
                                    }
                                    ?>
                                </td>
                                <td class="px-1 py-1"><?= $row['remarks'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if($history->num_rows <= 0): ?>
                                <tr>
                                    <th class="text-center" colspan="3">No records found</th>
                                </tr>
                            <?php endif; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<noscript id="print-header">
    <div>
        <div class="d-flex w-100 align-items-center">
            <div class="col-2 text-center">
                <img src="<?= validate_image($_settings->info('logo')) ?>" alt="" class="rounded-circle border" style="width: 5em; height: 5em; object-fit: cover; object-position: center center">
            </div>
            <div class="col-8">
                <div style="line-height: 1em">
                    <div class="text-center font-weight-bold"><large><?= $_settings->info('name') ?></large></div>
                    <div class="text-center font-weight-bold"><large>Request Details</large></div>
                </div>
            </div>
            <!-- Right logo based on district -->
            <div class="col-2 text-center">
                <?php
                $admin_district = $_settings->userdata('district');
                
                // Select the logo based on district
                $district_logo = '';
                if ($admin_district == 'Bantayan') {
                    $district_logo = $_settings->info('district_logo_bantayan');
                } elseif ($admin_district == 'Madridejos') {
                    $district_logo = $_settings->info('district_logo_madridejos');
                } elseif ($admin_district == 'Sta Fe') {
                    $district_logo = $_settings->info('district_logo_stafe');
                }
                ?>
                
                <!-- Display the selected logo -->
                <img src="<?= validate_image($district_logo) ?>" alt="" class="rounded-circle border" style="width: 5em; height: 5em; object-fit: cover; object-position: center center">
            </div>
        </div>
        <hr>
    </div>
</noscript>
<script>
    function print_t(){
        var h = $('head').clone()
        var el = ""
        $('.printout').map(function(){
            var p = $(this).clone()
                p.find('.btn').remove()
                p.find('.card').addClass('border')
                p.removeClass('col-lg-8 col-md-10 col-sm-12 col-xs-12')
                p.addClass('col-12')
            el += p[0].outerHTML
        })
        var ph = $($('noscript#print-header').html()).clone()
        h.find('title').text("request Details - Print View")
        var nw = window.open("", "_blank", "width="+($(window).width() * .8)+",left="+($(window).width() * .1)+",height="+($(window).height() * .8)+",top="+($(window).height() * .1))
            nw.document.querySelector('head').innerHTML = h.html()
            nw.document.querySelector('body').innerHTML = ph[0].outerHTML
            nw.document.querySelector('body').innerHTML += el
            nw.document.close()
            start_loader()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                    end_loader()
                }, 200);
            }, 300);
    }
    $(function(){
        $('#print').click(function(){
            print_t()
        })
        $('#assign_team').click(function(){
            uni_modal("Assign a Team", 'requests/assign_team.php?id=<?= isset($id) ? $id : '' ?>')
        })
        $('#delete_data').click(function(){
            _conf("Are you sure to delete this request permanently?","delete_request", ["<?= isset($id) ? $id :'' ?>"])
        })
        $('#update_status').click(function(){
            uni_modal("Update Status", "requests/take_action.php?id=<?= isset($id) ? $id : '' ?>")
        })
    })
    function delete_request($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_request",
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
                    location.replace("./?page=requests");
                }else{
                    alert_toast("An error occured.",'error');
                    end_loader();
                }
            }
        })
    }
</script>
