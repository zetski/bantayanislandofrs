<?php if($_settings->chk_flashdata('success')): ?>
    <script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
    </script>
<?php endif; ?>

<style>
    img#cimg {
        height: 300px; /* Adjust the height */
        width: 100%;   /* Make the image responsive */
        object-fit: cover; /* Ensure the image fills the container */
        border-radius: 0;  /* Remove rounded corners */
    }
</style>
<div class="col-lg-12">
    <div class="card card-outline rounded-0 card-danger">
        <div class="card-header">
            <h5 class="card-title">Manage Event</h5>
        </div>
        <div class="card-body">
        <form action="" id="event-frm" method="POST" enctype="multipart/form-data">
                <div id="msg" class="form-group"></div>

                <div class="form-group">
                    <label for="event_name" class="control-label">Event Name</label>
                    <select class="form-control form-control-sm" name="event_name" id="event_name" required>
                        <option value="" disabled selected>Select Event</option>
                        <option value="Earthquake Drill">Earthquake Drill</option>
                        <option value="Fire Drill">Fire Drill</option>
                        <option value="Flood Drill">Flood Drill</option>
                        <option value="Tornado Drill">Tornado Drill</option>
                        <option value="Hazardous Materials Drill">Hazardous Materials Drill</option>
                        <option value="Evacuation Drill">Evacuation Drill</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="event_description" class="control-label">Event Description</label>
                    <textarea name="event_description" id="event_description" cols="30" rows="4" class="form-control form-control-sm" required></textarea>
                </div>

                <div class="form-group">
                    <label for="event_date" class="control-label">Event Date & Time</label>
                    <div class="d-flex">
                        <input type="date" class="form-control form-control-sm" name="event_date" id="event_date" required style="flex: 1; margin-right: 5px;">
                        <input type="time" class="form-control form-control-sm" name="event_time" id="event_time" required style="flex: 1;">
                    </div>
                </div>

                <!-- Add Location Field -->
                <div class="form-group">
                    <label for="municipality" class="control-label">Municipality</label>
                    <select name="municipality" id="municipality" class="form-control form-control-sm" required>
                        <option value="" disabled selected>Select Municipality</option>
                        <option value="Santa Fe">Santa Fe</option>
                        <option value="Bantayan">Bantayan</option>
                        <option value="Madridejos">Madridejos</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="barangay" class="control-label">Barangay</label>
                    <select name="barangay" id="barangay" class="form-control form-control-sm" required>
                        <option value="" disabled selected>Select Barangay</option>
                        <!-- Barangay options will be dynamically populated based on selected municipality -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="sitio" class="control-label">Sitio/Specific Location</label>
                    <input type="text" class="form-control form-control-sm" name="sitio" id="sitio" required>
                </div>

                <div class="form-group">
                    <label for="event_image" class="control-label">Event Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="event_image" name="event_image" accept="image/*" onchange="displayImg(this,$(this))">
                        <label class="custom-file-label" for="event_image">Choose file</label>
                    </div>
                </div>

                <div class="form-group d-flex justify-content-center">
                    <img src="" alt="" id="cimg" class="img-fluid img-thumbnail">
                </div>

                <button class="btn btn-sm btn-primary" type="submit">Save Event</button>
            </form>
        </div>
    </div>
</div>

<script>
    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result); // Show the image
                _this.siblings('.custom-file-label').html(input.files[0].name); // Update file label
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0]; // Get current date in 'YYYY-MM-DD' format
        document.getElementById('event_date').setAttribute('min', today); // Set as min attribute
    });

    // Dynamically update barangays based on selected municipality
    document.getElementById('municipality').addEventListener('change', function() {
        var municipality = this.value;
        var barangayDropdown = document.getElementById('barangay');

        // Reset barangay dropdown
        barangayDropdown.innerHTML = '<option value="" disabled selected>Select Barangay</option>';

        if (municipality === 'Santa Fe') {
            barangayDropdown.innerHTML += '<option value="Balidbid">Balidbid</option><option value="Hagdan">Hagdan</option><option value="Hilantagaan">Hilantagaan</option><option value="Kinatarkan">Kinatarkan</option><option value="Langub">Langub</option><option value="Maricaban">Maricaban</option><option value="Okoy">Okoy</option><option value="Poblacion">Poblacion</option><option value="Pooc">Pooc</option><option value="Talisay">Talisay</option>';
        } else if (municipality === 'Bantayan') {
            barangayDropdown.innerHTML += '<option value="Atop-Atop">Atop-Atop</option><option value="Baigad">Baigad</option><option value="Bantigue">Bantigue</option><option value="Baod">Baod</option><option value="Binaobao">Binaobao</option><option value="Botigues">Botigues</option><option value="Doong">Doong</option><option value="Guiwanon">Guiwanon</option><option value="Hilotongan">Hilotongan</option><option value="Kabac">Kabac</option><option value="Kampinganon">Kampinganon</option><option value="Kabangbang">Kabangbang</option><option value="Kangkaibe">Kangkaibe</option><option value="Lipayran">Lipayran</option><option value="Luyong Baybay">Luyong Baybay</option><option value="Mojon">Mojon</option><option value="Oboob">Oboob</option><option value="Patao">Patao</option><option value="Putian">Putian</option><option value="Sillon">Sillon</option><option value="Suba">Suba</option><option value="Sulangan">Sulangan</option><option value="Sungko">Sungko</option><option value="Tamiao">Tamiao</option><option value="Ticad">Ticad</option>';
        } else if (municipality === 'Madridejos') {
            barangayDropdown.innerHTML += '<option value="Bunakan">Bunakan</option><option value="Kangwayan">Kangwayan</option><option value="Kaongkod">Kaongkod</option><option value="Kodia">Kodia</option><option value="Maalat">Maalat</option><option value="Malbago">Malbago</option><option value="Mancilang">Mancilang</option><option value="Pili">Pili</option><option value="Poblacion">Poblacion</option><option value="San Agustin">San Agustin</option><option value="Tabagak">Tabagak</option><option value="Talangnan">Talangnan</option><option value="Tarong">Tarong</option><option value="Tugas">Tugas</option>';
        }
    });

    // AJAX request for saving event
    $('#event-frm').submit(function(e){
        e.preventDefault(); // Prevent default form submission

        var formData = new FormData(this); // Collect all form data

        $.ajax({
            url: '../classes/Master.php?f=save_event', // Path to the save_event function
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                // Start loader (you can implement this as a custom function)
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
                            location.reload(); // Reload page after success
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
                end_loader(); // Stop loader (you can implement this as a custom function)
            },
            error: function(err){
                console.log(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.',
                    confirmButtonText: 'OK'
                });
                end_loader(); // Stop loader
            }
        });
    });
</script>


<!-- List of Events -->
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

    /* Table styling */
    .table {
        width: 100%;
        margin-top: 20px;
    }

    /* Action dropdown styling */
    .action-dropdown .dropdown-menu {
        min-width: 8rem;
    }
    .action-dropdown .dropdown-item i {
        margin-right: 5px;
    }
</style>

<div class="col-lg-12">
    <div class="card card-outline rounded-0 card-danger">
        <div class="card-header">
            <h5 class="card-title">Manage Event</h5>
        </div>
        <div class="card-body">
            <form action="" id="event-frm" method="POST" enctype="multipart/form-data">
                <!-- Form fields for Event -->
                <!-- <button class="btn btn-sm btn-primary" type="submit">Save Event</button> -->
            </form>

            <h5 class="mt-4">Event List</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Event Name</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Location</th> <!-- New column for combined location -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qry = $conn->query("SELECT * FROM events_list WHERE delete_flag = 0");
                    $i = 1;
                    while($row = $qry->fetch_assoc()):
                        $location = $row['municipality'] . ', ' . $row['barangay'] . ', ' . $row['sitio']; // Combine location fields
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['event_name']; ?></td>
                        <td><?php echo $row['event_description']; ?></td>
                        <td>
                            <?php 
                            echo date("F d, Y h:i A", strtotime($row['event_date'] . ' ' . $row['event_time'])); 
                            ?>
                        </td>
                        <td><?php echo $location; ?></td> <!-- Display combined location -->
                        <td>
                            <div class="dropdown action-dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <!-- Edit Button -->
                                    <a href="<?php echo base_url ?>admin/?page=system_info/edit_event&action=edit&id=<?php echo $row['id']; ?>" class="dropdown-item">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <!-- Delete Button -->
                                    <a href="javascript:void(0)" class="dropdown-item delete-event" data-id="<?php echo $row['id']; ?>">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $('.delete-event').click(function(){
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
                $.ajax({
                    url: _base_url_ + 'classes/Master.php?f=delete_event',
                    method: "POST",
                    data: {id: id},
                    success: function(resp){
                        resp = JSON.parse(resp); // Parse JSON response
                        if(resp.status === 'success'){
                            Swal.fire(
                                'Deleted!',
                                'The event has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload(); // Reload page after success
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to delete the event: ' + resp.message,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'An error occurred. Please try again.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
