<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>
<div class="content py-3 px-3" style="color: #fff; background-color: #ff4600">
    <h2><b>Contact information</b></h2>
</div>
<div class="row mt-lg-n4 mt-md-n4 justify-content-center">
    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
        <div class="card rounded-0 shadow">
            <div class="card-body">
                <form action="" id="system-frm">
                    <div id="msg" class="form-group"></div>
                    <div class="form-group">
                        <label for="phone" class="control-label">
                            <i class="fas fa-phone-alt"></i> Telephone #
                        </label>
                        <input type="text" class="form-control form-control-sm rounded-0" name="phone" id="phone" value="<?php echo $_settings->info('phone') ?>" maxlength="15" pattern="[\d\(\)\-]+" title="Please enter a valid phone number">
                    </div>
                    <div class="form-group">
                        <label for="mobile" class="control-label">
                            <i class="fas fa-mobile-alt"></i> Mobile #
                        </label>
                        <input type="text" class="form-control form-control-sm rounded-0" name="mobile" id="mobile" value="<?php echo $_settings->info('mobile') ?>" maxlength="11" pattern="\d{11}" title="Please enter exactly 11 digits">
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control form-control-sm rounded-0" name="email" id="email" value="<?php echo $_settings->info('email') ?>">
                    </div>
                    <!-- New Facebook field with icon -->
                    <div class="form-group">
                        <label for="facebook" class="control-label">
                            <i class="fab fa-facebook-square"></i> Facebook
                        </label>
                        <input type="url" class="form-control form-control-sm rounded-0" name="facebook" id="facebook" value="<?php echo $_settings->info('facebook') ?>" placeholder="https://www.facebook.com/yourprofile">
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">
                            <i class="fas fa-map-marker-alt"></i> Address
                        </label>
                        <textarea rows="3" class="form-control form-control-sm rounded-0" name="address" id="address"><?php echo $_settings->info('address') ?></textarea>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="col-md-12">
                    <div class="row">
                        <button class="btn btn-sm btn-primary" form="system-frm">Update Info</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#system-frm').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=update_settings",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
            });
        });

        // Restrict phone input to numbers, dashes, and parentheses
        $('#phone').on('input', function() {
            this.value = this.value.replace(/[^0-9\(\)\-]/g, '');
        });

        // Restrict mobile input to numbers only
        $('#mobile').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
