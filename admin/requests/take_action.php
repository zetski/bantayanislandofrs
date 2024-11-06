<?php 
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `request_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="take-action-form">
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="status" class="control-label">Action</label>
            <select class="form-control form-control-sm rounded-0" name="status" id="status" required="required">
                <option value="" selected disabled>Please Select Here</option>
                <?php if($status < 2): ?>
                    <option value="2">Team is on their way</option>
                <?php endif; ?>
                <?php if($status < 3): ?>
                    <option value="3">Fire Relief is in progress</option>
                <?php endif; ?>
                <?php if($status < 4): ?>
                    <option value="4">Fire Relief Completed</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="remarks" class="control-label">Remarks</label>
            <textarea name="remarks" id="remarks" rows="3" class="form-control form-control-sm rounded-0"></textarea>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('#take-action-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=take_action",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    end_loader();
                },
                success: function(resp){
                    end_loader();
                    if(typeof resp === 'object' && resp.status === 'success'){
                        Swal.fire({
                            title: 'Success!',
                            text: 'Action has been taken successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else if(resp.status === 'failed' && !!resp.msg){
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body, .modal").scrollTop(0);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.log(resp);
                    }
                }
            });
        });
    });
</script>
