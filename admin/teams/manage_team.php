<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `team_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<style>
    #team-logo{
        max-width:100%;
        max-height:20em;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="content py-3 px-3" style="background-color: #ff4600; color: #fff">
    <h2><b><?= isset($id) ? "Update Team's Details" : "New Team Entry" ?></b></h2>
</div>
<div class="row mt-lg-n4 mt-md-n4 justify-content-center">
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
        <div class="card rounded-0">
            <div class="card-body">
                <div class="container-fluid">
                    <form action="" id="team-form">
                        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="code" class="control-label">Team Code</label>
                            <input type="text" name="code" id="code" class="form-control form-control-sm rounded-0" value="<?php echo isset($code) ? $code : ''; ?>" required/>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="district" class="control-label">District</label>
                            <input type="text" name="district" id="district" class="form-control form-control-sm rounded-0" 
                                value="<?php echo isset($district) ? $district : ''; ?>" required/>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="leader_name" class="control-label">TL Name</label>
                            <input type="text" name="leader_name" id="leader_name" class="form-control form-control-sm rounded-0" value="<?php echo isset($leader_name) ? $leader_name : ''; ?>" required pattern="[A-Za-z\s.,-]*" title="Only letters, commas, periods, and dashes allowed"/>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="leader_contact" class="control-label">TL Contact #</label>
                            <input type="text" name="leader_contact" id="leader_contact" class="form-control form-control-sm rounded-0" value="<?php echo isset($leader_contact) ? $leader_contact : ''; ?>" required pattern="\d{11}" title="Please enter exactly 11 digits" maxlength="11"/>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="members" class="control-label">Members</label>
                            <textarea rows="3" name="members" id="members" class="form-control form-control-sm rounded-0" required><?php echo isset($members) ? $members : ''; ?></textarea>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer py-1 text-center">
                <button class="btn btn-primary btn-sm bg-gradient-primary btn-flat" form="team-form"><i class="fa fa-save"></i> Save</button>
                <a class="btn btn-light btn-sm bg-gradient-light border btn-flat" href="./?page=teams"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>
<script>
    function displayImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#team-logo').attr('src', e.target.result);
                $(input).siblings('.custom-file-label').html(input.files[0].name)
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#team-logo').attr('src', '<?= validate_image(isset($image_path) ? $image_path : '') ?>');
            $(input).siblings('.custom-file-label').html(input.files[0].name)
        }
    }

    $(document).ready(function(){
        $('#description').summernote({
            height: '30em',
            placeholder: "Write the team description here.",
            toolbar: [
                [ 'style', [ 'style' ] ],
                [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                [ 'fontname', [ 'fontname' ] ],
                [ 'fontsize', [ 'fontsize' ] ],
                [ 'color', [ 'color' ] ],
                [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                [ 'table', [ 'table' ] ],
                [ 'view', [ 'undo', 'redo', 'fullscreen', 'help' ] ]
            ]
        });

        $('#leader_contact').on('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
        });

        $('#leader_name').on('input', function(e) {
            this.value = this.value.replace(/[^A-Za-z\s.,-]/g, '');
        });

        $('#team-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_team",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp){
                    if (typeof resp === 'object' && resp.status === 'success'){
                        location.replace('./?page=teams/view_team&id=' + resp.aid);
                    } else if (resp.status === 'failed' && !!resp.msg){
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                    }
                }
            });
        });
    });
</script>
