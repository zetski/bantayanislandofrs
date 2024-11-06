<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `request_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<style>
    #request-logo{
        max-width:100%;
        max-height:20em;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="content py-3 px-3" style="background-color: #ff4600; color: #fff">
    <h2><b><?= isset($code) ? "Update <b>{$code}</b> Request Detail" : "New Request Entry" ?></b></h2>
</div>
<div class="row mt-lg-n4 mt-md-n4 justify-content-center">
    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
        <div class="card rounded-0">
            <div class="card-body">

                <div class="container-fluid">
                    <form action="" id="request-form">
                        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                        
                        <div class="form-group">
                            <label for="lastname" class="control-label">Last Name <small class="text-danger">*</small></label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="lastname" id="lastname" required="required" value="<?= isset($lastname) ? $lastname : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="control-label">First Name <small class="text-danger">*</small></label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="firstname" id="firstname" required="required" value="<?= isset($firstname) ? $firstname : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="middlename" class="control-label">Middle Name</label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="middlename" id="middlename" value="<?= isset($middlename) ? $middlename : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="contact" class="control-label">Contact # <small class="text-danger">*</small></label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="contact" id="contact" required="required" value="<?= isset($contact) ? $contact : '' ?>" maxlength="11" oninput="validateContact()">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="control-label">Subject <small class="text-danger">*</small></label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="subject" id="subject" required="required" value="<?= isset($subject) ? $subject : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="message" class="control-label">Message <small class="text-danger">*</small></label>
                            <textarea rows="3" class="form-control form-control-sm rounded-0" name="message" id="message" required="required"><?= isset($message) ? $message : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="municipality" class="control-label">Municipality <small class="text-danger">*</small></label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="municipality" id="municipality" required="required" value="<?= isset($municipality) ? $municipality : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="barangay" class="control-label">Barangay <small class="text-danger">*</small></label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="barangay" id="barangay" required="required" value="<?= isset($barangay) ? $barangay : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="sitio_street" class="control-label">Sitio/Street <small class="text-danger">*</small></label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="sitio_street" id="sitio_street" required="required" value="<?= isset($sitio_street) ? $sitio_street : '' ?>">
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer py-1 text-center">
                <button class="btn btn-primary btn-sm bg-gradient-primary btn-flat" form="request-form"><i class="fa fa-save"></i> Save</button>
                <a class="btn btn-light btn-sm bg-gradient-light border btn-flat" href="./?page=requests"><i class="fa fa-angle-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        
        $('#request-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_request",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("An error occurred",'error');
                    end_loader();
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        location.replace('./?page=requests/view_request&id='+resp.tid)
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
                        alert_toast("An error occurred",'error');
                        end_loader();
                        console.log(resp)
                    }
                }
            })
        })

    });

    function validateContact() {
        var contact = document.getElementById('contact');
        contact.value = contact.value.replace(/[^0-9]/g, '').substring(0, 11);
    }
</script>
