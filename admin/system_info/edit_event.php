<?php
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $qry = $conn->query("SELECT * FROM events_list WHERE id = {$id} AND delete_flag = 0");
    if($qry->num_rows > 0){
        $event = $qry->fetch_assoc();
    } else {
        echo "<script>alert('Invalid Event ID'); location.replace('event_list.php');</script>";
    }
} else {
    echo "<script>alert('No Event ID provided'); location.replace('event_list.php');</script>";
}
?>

<?php if($_settings->chk_flashdata('success')): ?>
    <script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
    </script>
<?php endif; ?>

<style>
    img#cimg {
        height: 300px;
        width: 100%;
        object-fit: cover;
        border-radius: 0;
    }
</style>

<div class="col-lg-12">
    <div class="card card-outline rounded-0 card-danger">
        <div class="card-header">
            <h5 class="card-title">Manage Event</h5>
        </div>
        <div class="card-body">
            <form action="" id="event-frm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div id="msg" class="form-group"></div>

                <div class="form-group">
                    <label for="event_name" class="control-label">Event Name</label>
                    <select class="form-control form-control-sm" name="event_name" id="event_name" required>
                        <option value="" disabled>Select Event</option>
                        <option value="Earthquake Drill" <?php echo $event['event_name'] == 'Earthquake Drill' ? 'selected' : '' ?>>Earthquake Drill</option>
                        <option value="Fire Drill" <?php echo $event['event_name'] == 'Fire Drill' ? 'selected' : '' ?>>Fire Drill</option>
                        <option value="Flood Drill" <?php echo $event['event_name'] == 'Flood Drill' ? 'selected' : '' ?>>Flood Drill</option>
                        <option value="Tornado Drill" <?php echo $event['event_name'] == 'Tornado Drill' ? 'selected' : '' ?>>Tornado Drill</option>
                        <option value="Hazardous Materials Drill" <?php echo $event['event_name'] == 'Hazardous Materials Drill' ? 'selected' : '' ?>>Hazardous Materials Drill</option>
                        <option value="Evacuation Drill" <?php echo $event['event_name'] == 'Evacuation Drill' ? 'selected' : '' ?>>Evacuation Drill</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="event_description" class="control-label">Event Description</label>
                    <textarea name="event_description" id="event_description" cols="30" rows="4" class="form-control form-control-sm" required><?php echo $event['event_description']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="event_date" class="control-label">Event Date</label>
                    <input type="date" class="form-control form-control-sm" name="event_date" id="event_date" value="<?php echo date('Y-m-d', strtotime($event['event_date'])); ?>" required>
                </div>

                <div class="form-group">
                    <label for="event_time" class="control-label">Event Time</label>
                    <input type="time" class="form-control form-control-sm" name="event_time" id="event_time" value="<?php echo date('H:i', strtotime($event['event_time'])); ?>" required>
                </div>

                <!-- Location Fields -->
                <div class="form-group">
                    <label for="municipality" class="control-label">Municipality</label>
                    <select name="municipality" id="municipality" class="form-control form-control-sm" required>
                        <option value="" disabled>Select Municipality</option>
                        <option value="Santa Fe" <?php echo $event['municipality'] == 'Santa Fe' ? 'selected' : '' ?>>Santa Fe</option>
                        <option value="Bantayan" <?php echo $event['municipality'] == 'Bantayan' ? 'selected' : '' ?>>Bantayan</option>
                        <option value="Madridejos" <?php echo $event['municipality'] == 'Madridejos' ? 'selected' : '' ?>>Madridejos</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="barangay" class="control-label">Barangay</label>
                    <select name="barangay" id="barangay" class="form-control form-control-sm" required>
                        <option value="" disabled>Select Barangay</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sitio" class="control-label">Sitio/Specific Location</label>
                    <input type="text" class="form-control form-control-sm" name="sitio" id="sitio" value="<?php echo $event['sitio']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="event_image" class="control-label">Event Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="event_image" name="event_image" accept="image/*" onchange="displayImg(this,$(this))">
                        <label class="custom-file-label" for="event_image">Choose file</label>
                    </div>
                </div>

                <div class="form-group d-flex justify-content-center">
                    <img src="<?php echo isset($event['image_path']) ? $event['image_path'] : ''; ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
                </div>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-sm btn-primary" type="submit">Update Event</button>
                    <a href="<?php echo base_url ?>admin/?page=system_info/event_info" class="btn btn-sm btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
                _this.siblings('.custom-file-label').html(input.files[0].name);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('event_date').setAttribute('min', today);

        // Set initial barangays based on loaded event data
        populateBarangays('<?php echo $event['municipality']; ?>', '<?php echo $event['barangay']; ?>');
        
        document.getElementById('municipality').addEventListener('change', function() {
            populateBarangays(this.value);
        });
    });

    function populateBarangays(municipality, selectedBarangay = '') {
        var barangayDropdown = document.getElementById('barangay');
        barangayDropdown.innerHTML = '<option value="" disabled>Select Barangay</option>';
        
        if (municipality === 'Santa Fe') {
            barangayDropdown.innerHTML += '<option value="Balidbid" ' + (selectedBarangay == 'Balidbid' ? 'selected' : '') + '>Balidbid</option>';
            barangayDropdown.innerHTML += '<option value="Hagdan" ' + (selectedBarangay == 'Hagdan' ? 'selected' : '') + '>Hagdan</option>';
            barangayDropdown.innerHTML += '<option value="Hilantagaan" ' + (selectedBarangay == 'Hilantagaan' ? 'selected' : '') + '>Hilantagaan</option>';
            barangayDropdown.innerHTML += '<option value="Kinatarkan" ' + (selectedBarangay == 'Kinatarkan' ? 'selected' : '') + '>Kinatarkan</option>';
            barangayDropdown.innerHTML += '<option value="Langub" ' + (selectedBarangay == 'Langub' ? 'selected' : '') + '>Langub</option>';
            barangayDropdown.innerHTML += '<option value="Maricaban" ' + (selectedBarangay == 'Maricaban' ? 'selected' : '') + '>Maricaban</option>';
            barangayDropdown.innerHTML += '<option value="Okoy" ' + (selectedBarangay == 'Okoy' ? 'selected' : '') + '>Okoy</option>';
            barangayDropdown.innerHTML += '<option value="Poblacion" ' + (selectedBarangay == 'Poblacion' ? 'selected' : '') + '>Poblacion</option>';
            barangayDropdown.innerHTML += '<option value="Pooc" ' + (selectedBarangay == 'Pooc' ? 'selected' : '') + '>Pooc</option>';
            barangayDropdown.innerHTML += '<option value="Talisay" ' + (selectedBarangay == 'Talisay' ? 'selected' : '') + '>Talisay</option>';
        } else if (municipality === 'Bantayan') {
            barangayDropdown.innerHTML += '<option value="Atop-Atop" ' + (selectedBarangay == 'Atop-Atop' ? 'selected' : '') + '>Atop-Atop</option>';
            barangayDropdown.innerHTML += '<option value="Baigad" ' + (selectedBarangay == 'Baigad' ? 'selected' : '') + '>Baigad</option>';
            barangayDropdown.innerHTML += '<option value="Bantigue" ' + (selectedBarangay == 'Bantigue' ? 'selected' : '') + '>Bantigue</option>';
            barangayDropdown.innerHTML += '<option value="Baod" ' + (selectedBarangay == 'Baod' ? 'selected' : '') + '>Baod</option>';
            barangayDropdown.innerHTML += '<option value="Binaobao" ' + (selectedBarangay == 'Binaobao' ? 'selected' : '') + '>Binaobao</option>';
            barangayDropdown.innerHTML += '<option value="Botigues" ' + (selectedBarangay == 'Botigues' ? 'selected' : '') + '>Botigues</option>';
            barangayDropdown.innerHTML += '<option value="Doong" ' + (selectedBarangay == 'Doong' ? 'selected' : '') + '>Doong</option>';
            barangayDropdown.innerHTML += '<option value="Guiwanon" ' + (selectedBarangay == 'Guiwanon' ? 'selected' : '') + '>Guiwanon</option>';
            barangayDropdown.innerHTML += '<option value="Hilotongan" ' + (selectedBarangay == 'Hilotongan' ? 'selected' : '') + '>Hilototngan</option>';
            barangayDropdown.innerHTML += '<option value="Kabac" ' + (selectedBarangay == 'Kabac' ? 'selected' : '') + '>Kabac</option>';
            barangayDropdown.innerHTML += '<option value="Kabangbang" ' + (selectedBarangay == 'Kabangbang' ? 'selected' : '') + '>Kabangbang</option>';
            barangayDropdown.innerHTML += '<option value="Kampinganon" ' + (selectedBarangay == 'Kampinganon' ? 'selected' : '') + '>Kampinganon</option>';
            barangayDropdown.innerHTML += '<option value="Kangkaibe" ' + (selectedBarangay == 'Kangkaibe' ? 'selected' : '') + '>Kangkaibe</option>';
            barangayDropdown.innerHTML += '<option value="Lipayran" ' + (selectedBarangay == 'Lipayran' ? 'selected' : '') + '>Lipayran</option>';
            barangayDropdown.innerHTML += '<option value="Luyongbay-bay" ' + (selectedBarangay == 'Luyongbay-bay' ? 'selected' : '') + '>Luyongbay-bay</option>';
            barangayDropdown.innerHTML += '<option value="Mojon" ' + (selectedBarangay == 'Mojon' ? 'selected' : '') + '>Mojon</option>';
            barangayDropdown.innerHTML += '<option value="Oboob" ' + (selectedBarangay == 'Oboob' ? 'selected' : '') + '>Oboob</option>';
            barangayDropdown.innerHTML += '<option value="Patao" ' + (selectedBarangay == 'Patao' ? 'selected' : '') + '>Patao</option>';
            barangayDropdown.innerHTML += '<option value="Putian" ' + (selectedBarangay == 'Putian' ? 'selected' : '') + '>Putian</option>';
            barangayDropdown.innerHTML += '<option value="Sillon" ' + (selectedBarangay == 'Sillon' ? 'selected' : '') + '>Sillon</option>';
            barangayDropdown.innerHTML += '<option value="Suba" ' + (selectedBarangay == 'Suba' ? 'selected' : '') + '>Suba</option>';
            barangayDropdown.innerHTML += '<option value="Sulangan" ' + (selectedBarangay == 'Sulangan' ? 'selected' : '') + '>Sulangan</option>';
            barangayDropdown.innerHTML += '<option value="Sungko" ' + (selectedBarangay == 'Sungko' ? 'selected' : '') + '>Sungko</option>';
            barangayDropdown.innerHTML += '<option value="Tamiao" ' + (selectedBarangay == 'Tamiao' ? 'selected' : '') + '>Tamiao</option>';
            barangayDropdown.innerHTML += '<option value="Ticad" ' + (selectedBarangay == 'Ticad' ? 'selected' : '') + '>Ticad</option>';
            // Add other barangays for Bantayan similarly
        } else if (municipality === 'Madridejos') {
            barangayDropdown.innerHTML += '<option value="Bunakan" ' + (selectedBarangay == 'Bunakan' ? 'selected' : '') + '>Bunakan</option>';
            barangayDropdown.innerHTML += '<option value="Kangwayan" ' + (selectedBarangay == 'Kangwayan' ? 'selected' : '') + '>Kangwayan</option>';
            barangayDropdown.innerHTML += '<option value="Kaongkod" ' + (selectedBarangay == 'Kaongkod' ? 'selected' : '') + '>Kaongkod</option>';
            barangayDropdown.innerHTML += '<option value="Kodia" ' + (selectedBarangay == 'Kodia' ? 'selected' : '') + '>Kodia</option>';
            barangayDropdown.innerHTML += '<option value="Maalat" ' + (selectedBarangay == 'Maalat' ? 'selected' : '') + '>Maalat</option>';
            barangayDropdown.innerHTML += '<option value="Malbago" ' + (selectedBarangay == 'Malbago' ? 'selected' : '') + '>Malbago</option>';
            barangayDropdown.innerHTML += '<option value="Mancilang" ' + (selectedBarangay == 'Mancilang' ? 'selected' : '') + '>Mancilang</option>';
            barangayDropdown.innerHTML += '<option value="Pili" ' + (selectedBarangay == 'Pili' ? 'selected' : '') + '>Pili</option>';
            barangayDropdown.innerHTML += '<option value="Poblacion" ' + (selectedBarangay == 'Poblacion' ? 'selected' : '') + '>Poblacion</option>';
            barangayDropdown.innerHTML += '<option value="San Agustin" ' + (selectedBarangay == 'San Agustin' ? 'selected' : '') + '>San Agustin</option>';
            barangayDropdown.innerHTML += '<option value="Tabagak" ' + (selectedBarangay == 'Tabagak' ? 'selected' : '') + '>Tabagak</option>';
            barangayDropdown.innerHTML += '<option value="Talangnan" ' + (selectedBarangay == 'Talangnan' ? 'selected' : '') + '>Talangnan</option>';
            barangayDropdown.innerHTML += '<option value="Tarong" ' + (selectedBarangay == 'Tarong' ? 'selected' : '') + '>Tarong</option>';
            barangayDropdown.innerHTML += '<option value="Tugas" ' + (selectedBarangay == 'Tugas' ? 'selected' : '') + '>Tugas</option>';
            // Add other barangays for Madridejos similarly
        }
    }

    $('#event-frm').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '../classes/Master.php?f=save_event',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                start_loader();
            },
            success: function(resp){
                if (resp.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: resp.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if(result.isConfirmed){
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: resp.message,
                        confirmButtonText: 'OK'
                    });
                }
                end_loader();
            },
            error: function(){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.',
                    confirmButtonText: 'OK'
                });
                end_loader();
            }
        });
    });
</script>
