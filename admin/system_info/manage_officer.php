<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM officers WHERE id = {$_GET['id']}");
    foreach ($qry->fetch_assoc() as $k => $v) {
        $$k = $v;
    }
}
?>

<form action="" id="officer-form">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
    <div class="form-group">
        <label for="lastname">Lastname</label>
        <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($lastname) ? $lastname : ''; ?>" required>
    </div>
    <div class="form-group">
        <label for="firstname">Firstname</label>
        <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($firstname) ? $firstname : ''; ?>" required>
    </div>
    <div class="form-group">
        <label for="middlename">Middlename</label>
        <input type="text" name="middlename" id="middlename" class="form-control" value="<?php echo isset($middlename) ? $middlename : ''; ?>">
    </div>
    <div class="form-group">
        <label for="position">Position</label>
        <input type="text" name="position" id="position" class="form-control" value="<?php echo isset($position) ? $position : ''; ?>" required>
    </div>
</form>

<script>
$('#officer-form').submit(function(e){
    e.preventDefault();
    start_loader();
    $.ajax({
        url: _base_url_ + 'classes/Master.php?f=save_officer',
        data: $(this).serialize(),
        method: 'POST',
        success: function(resp){
            if (resp == 1) {
                alert_toast("Officer successfully saved", 'success');
                setTimeout(function(){
                    location.reload();
                }, 1500);
            }
        }
    });
});
</script>
