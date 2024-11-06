<?php 
require_once('../../config.php');

// Get the current logged-in admin's district
$admin_district = $_settings->userdata('district');

if (isset($_GET['id']) && $_GET['id'] > 0) {
    // Fetch the request details
    $qry = $conn->query("SELECT * FROM `request_list` WHERE id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="assign-form">
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="team_id" class="control-label">Assigned To Team<small class="text-danger">*</small></label>
            <select class="form-control form-control-sm rounded-0" name="team_id" id="team_id" required="required">
                <option value="" disabled <?= !isset($team_id) ? 'selected' : '' ?>></option>
                <?php 
                // Get teams that belong to the admin's district and are available
                $teams = $conn->query("
                    SELECT tl.*, 
                           COALESCE((SELECT r.status FROM request_list r WHERE r.team_id = tl.id AND r.status IN (1,2,3)), 0) AS team_status 
                    FROM team_list tl 
                    WHERE tl.delete_flag = 0 
                      AND tl.district = '{$admin_district}' 
                      AND NOT EXISTS (
                          SELECT 1 FROM request_list r 
                          WHERE r.team_id = tl.id 
                          AND r.status IN (1, 2, 3)  -- Adjust status codes as necessary
                      )
                    ORDER BY tl.code ASC
                ");

                while ($row = $teams->fetch_assoc()):
                ?>
                <option value="<?= $row['id'] ?>" <?= isset($team_id) && $team_id == $row['id'] ? 'selected' : '' ?>>
                    <?= $row['code'] ?> [TL: <?= $row['leader_name'] ?>]
                </option>
                <?php endwhile; ?>
            </select>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('#uni_modal').on('shown.bs.modal', function(){
            $('#team_id').select2({
                placeholder:"Please Select Team Here",
                width:"100%",
                dropdownParent:$('#uni_modal'),
                containerCssClass:'form-control form-control-sm rounded-0'
            });
        });
        $('#assign-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=assign_team",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred",'error');
                    end_loader();
                },
                success: function(resp){
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.reload();
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body, .modal").scrollTop(0);
                        end_loader();
                    } else {
                        alert_toast("An error occurred",'error');
                        end_loader();
                        console.log(resp);
                    }
                }
            });
        });
    });
</script>
