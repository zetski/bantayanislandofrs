<?php 
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '2021-01-01';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
$admin_district = $_settings->userdata('district'); // Get the admin's district

// Modify the SQL query to filter by the municipality for the Bantayan District admin
if ($from_date && $to_date) {
    $requests = $conn->query("SELECT * FROM `request_list` WHERE municipality = '{$admin_district}' AND date(date_created) BETWEEN '{$from_date}' AND '{$to_date}' ORDER BY abs(unix_timestamp(date_created)) asc ");
} else {
    $requests = $conn->query("SELECT * FROM `request_list` WHERE municipality = '{$admin_district}' ORDER BY abs(unix_timestamp(date_created)) asc ");
}
?>

<div class="content py-3 px-3" style="color: #fff; background-color: #ff4600">
    <h2>Daily Report</h2>
</div>
<div class="row flex-column mt-4 justify-content-center align-items-center mt-lg-n4 mt-md-3 mt-sm-0">
    <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
        <div class="card rounded-0 mb-2 shadow">
            <div class="card-body">
                <fieldset>
                    <legend>Filter</legend>
                    <form action="" id="filter-form">
                        <div class="row align-items-end">
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="from_date" class="control-label">From Date</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" name="from_date" id="from_date" value="<?= isset($_GET['from_date']) ? $_GET['from_date'] : '' ?>" required="required">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="to_date" class="control-label">To Date</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" name="to_date" id="to_date" value="<?= isset($_GET['to_date']) ? $_GET['to_date'] : '' ?>" required="required">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button class="btn btn-sm btn-flat btn-primary bg-gradient-primary"><i class="fa fa-filter"></i> Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
        <div class="card rounded-0 mb-2 shadow">
            <div class="card-header py-1">
                <div class="card-tools">
                    <button class="btn btn-flat btn-sm btn-light bg-gradient-light border" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid" id="printout">
                    <table class="table table-bordered">
                        <colgroup>
                            <col width="5%">
                            <col width="20%">
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="px-1 py-1 text-center">#</th>
                                <th class="px-1 py-1 text-center">Request Code</th>
                                <th class="px-1 py-1 text-center">Reported By</th>
                                <th class="px-1 py-1 text-center">Message</th>
                                <th class="px-1 py-1 text-center">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            while ($row = $requests->fetch_assoc()):
                                $purok_street = isset($row['sitio_street']) ? htmlspecialchars($row['sitio_street']) : '';
                                $barangay = isset($row['barangay']) ? htmlspecialchars($row['barangay']) : '';
                                $municipality = isset($row['municipality']) ? htmlspecialchars($row['municipality']) : '';
                            ?>
                            <tr>
                                <td class="px-1 py-1 align-middle text-center"><?= $i++ ?></td>
                                <td class="px-1 py-1 align-middle"><?= htmlspecialchars($row['code']) ?></td>
                                <td class="px-1 py-1 align-middle">
                                    <strong><?= htmlspecialchars($row['lastname']) ?>, </strong>
                                    <strong><?= htmlspecialchars($row['firstname']) ?> </strong>
                                    <strong><?= htmlspecialchars($row['middlename']) ?><br></strong>
                                    <?= htmlspecialchars($row['contact']) ?>
                                </td>
                                <td class="px-1 py-1 align-middle">
                                    Subject: <?= htmlspecialchars($row['subject']) ?><br>
                                    <?= nl2br(htmlspecialchars($row['message'])) ?>
                                </td>
                                <td class="px-1 py-1 align-middle">
                                    <?= $purok_street ?>, 
                                    <?= $barangay ?>, 
                                    <?= $municipality ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if ($requests->num_rows <= 0): ?>
                                <tr>
                                    <td class="py-1 text-center" colspan="5">No records found</td>
                                </tr>
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
        <style>
            html {
                min-height: unset !important;
            }
        </style>
        <div class="d-flex w-100 align-items-center">
            <!-- Left logo -->
            <div class="col-2 text-center">
                <img src="<?= validate_image($_settings->info('logo')) ?>" alt="" class="rounded-circle border" style="width: 5em; height: 5em; object-fit: cover; object-position: center center">
            </div>
            
            <!-- Centered Text Information -->
            <div class="col-8">
                <div style="line-height: 1em">
                    <div class="text-center font-weight-bold h5 mb-0"><large><?= $_settings->info('name') ?></large></div>
                    <div class="text-center font-weight-bold h5 mb-0"><large>Daily Requests Report</large></div>
                    <div class="text-center font-weight-bold h5 mb-0">From <?= date("F d, Y", strtotime($from_date)) ?> to <?= date("F d, Y", strtotime($to_date)) ?></div>
                </div>
            </div>
            
            <!-- Right logo based on district -->
            <div class="col-2 text-center">
                <?php
                $admin_district = $_settings->userdata('district');
                
                // Select the logo based on district
                // $district_logo = '';
                // if ($admin_district == 'Bantayan') {
                //     $district_logo = $_settings->info('district_logo_bantayan');
                // } elseif ($admin_district == 'Madridejos') {
                //     $district_logo = $_settings->info('district_logo_madridejos');
                // } elseif ($admin_district == 'Sta Fe') {
                //     $district_logo = $_settings->info('district_logo_stafe');
                // }

                if ($admin_district == 'Bantayan') {
                    $district_logo = $_settings->info('district_logo_bantayan');
                } elseif ($admin_district == 'Madridejos') {
                    $district_logo = $_settings->info('district_logo_madridejos');
                } elseif ($admin_district == 'Santa Fe') { // Ensure "Santa Fe" matches the saved value
                    $district_logo = $_settings->info('district_logo_stafe');
                } else {
                    $district_logo = 'default_logo_path'; // Path to a default logo image
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
    function print_r(){
        var h = $('head').clone()
        var el = $('#printout').clone()
        var ph = $($('noscript#print-header').html()).clone()
        h.find('title').text("Daily Report - Print View")
        var nw = window.open("", "_blank", "width="+($(window).width() * .8)+",left="+($(window).width() * .1)+",height="+($(window).height() * .8)+",top="+($(window).height() * .1))
            nw.document.querySelector('head').innerHTML = h.html()
            nw.document.querySelector('body').innerHTML = ph[0].outerHTML
            nw.document.querySelector('body').innerHTML += el[0].outerHTML
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
        $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = './?page=reports&'+$(this).serialize()
        })
        $('#print').click(function(){
            print_r()
        })
        
        // Set min and max dates for the date inputs
        var today = new Date().toISOString().split('T')[0];
        var from_date_input = document.getElementById('from_date');
        var to_date_input = document.getElementById('to_date');
        
        from_date_input.max = today;
        to_date_input.min = today;
    })
</script>
