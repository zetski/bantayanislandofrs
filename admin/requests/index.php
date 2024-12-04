<?php if ($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>

<?php 
$status = isset($_GET['status']) ? $_GET['status'] : '';
$stat_arr = ['Pending Requests', 'Assigned to a Team', 'Request where a Team is on their Way', 'Requests where Fire Relief is on Progress', 'Requests where Fire Relief Completed'];

// Fetch the admin's district from session or database
$admin_district = $_settings->userdata('district');

?>
<style>
    /* General Styles */
    .card-body {
        overflow-x: auto; /* Enable horizontal scrolling for tables */
    }

    /* Responsive Table */
    @media (max-width: 768px) {
        .table th,
        .table td {
            font-size: 12px;
            padding: 8px;
        }
        .btn {
            font-size: 10px; /* Smaller button font */
        }
        .modal-content {
            font-size: 12px; /* Smaller modal font for small screens */
        }
    }

    @media (max-width: 576px) {
        .table th,
        .table td {
            white-space: nowrap; /* Prevent text wrapping in small screens */
        }
        .card-header .card-title {
            font-size: 14px;
        }
    }

    /* Action Dropdown for Small Screens */
    @media (max-width: 400px) {
        .dropdown-menu {
            font-size: 12px; /* Reduce font size for dropdown options */
        }
    }
</style>

<div class="card card-outline rounded-0 card-danger">
    <div class="card-header">
        <h3 class="card-title">List of <?= isset($stat_arr[$status]) ? $stat_arr[$status] : 'All Requests' ?></h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-hover table-striped table-bordered" id="list">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="20%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Created</th>
                        <th>Code</th>
                        <th>Reported By</th>
                        <th>Message</th>
                        <th>Address</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $where = " WHERE `status` != 5 "; // Only fetch non-deleted requests
                    
                    // Add status-based filtering
                    switch ($status) {
                        case 0:
                            $where .= " AND `status` = 0 ";
                            break;
                        case 1:
                            $where .= " AND `status` = 1 ";
                            break;
                        case 2:
                            $where .= " AND `status` = 2 ";
                            break;
                        case 3:
                            $where .= " AND `status` = 3 ";
                            break;
                        case 4:
                            $where .= " AND `status` = 4 ";
                            break;
                    }

                    // Filter by municipality matching the admin's district
                    $where .= " AND `municipality` = '{$admin_district}' ";

                    $qry = $conn->query("SELECT * FROM `request_list` {$where} ORDER BY abs(unix_timestamp(date_created)) DESC");
                    while ($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                            <td><?php echo $row['code'] ?></td>
                            <td>
                                <?php echo $row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename']; ?><br>
                                <small><?php echo $row['contact']; ?></small>
                            </td>
                            <td>
                                <span>Subject: <?php echo $row['subject']; ?></span><br>
                                <span><?php echo $row['message']; ?></span>
                            </td>
                            <td>
                                <?php 
                                    echo $row['sitio_street'] . ', ' . $row['barangay'] . ', ' . ucwords(str_replace('_', ' ', $row['municipality']));
                                ?>
                            </td>
                            <td>
                                <?php
                                // Define the base directory where images are stored
                                $baseDir = '../uploads/';

                                // Check if the photo field is not empty and if the file exists
                                $imagePath = !empty($row['image']) && file_exists($baseDir . $row['image']) 
                                            ? $baseDir . $row['image'] 
                                            : $baseDir . 'default-image.jpg';
                                ?>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#imageModal<?php echo $i; ?>">
                                    <img src="<?php echo htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8'); ?>" alt="Image" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                </a>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="./?page=requests/view_request&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="./?page=requests/manage_request&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-right">
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.delete_data').click(function() {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    delete_request(id, $(this).closest('tr')); // Pass the row to delete
                }
            });
        });

        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: [6] }
            ],
            order: [0, 'asc']
        });

        $('.dataTable td, .dataTable th').addClass('py-1 px-2 align-middle');
    });

    function delete_request(id, row) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_request",
            method: "POST",
            data: { id: id },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                end_loader();
                if (typeof resp == 'object' && resp.status == 'success') {
                    Swal.fire(
                        'Deleted!',
                        'Item successfully deleted.',
                        'success'
                    ).then(() => {
                        // Remove the deleted row from the table without reloading the page
                        $(row).fadeOut('slow', function() {
                            $(this).remove();
                        });
                    });
                } else {
                    alert_toast("An error occurred.", 'error');
                }
            }
        });
    }
</script>
