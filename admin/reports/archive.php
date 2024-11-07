<?php
// archive.php
include_once '../classes/DBConnection.php'; // Include your DB connection




// Assuming $_settings->userdata('district') holds the admin's district
$admin_district = $_settings->userdata('district');

// Check if district is set before running the query
if ($admin_district) {
    $qry = $conn->query("SELECT * FROM request_list WHERE deleted_reports IS NOT NULL AND municipality = '" . $admin_district . "'");
} else {
    echo "District information is missing. Please log in again.";
}
?>
<!DOCTYPE html>
<html>
<style>
  .dataTables_length select {
    width: auto; /* Makes the dropdown width proper */
    padding: 5px; /* Ensures proper spacing */
    padding-right: 15px;
    font-size: 14px; /* Adjust font size to match the rest */
  }

  .dataTables_wrapper .dataTables_length label {
    display: flex;
    align-items: center;
  }

  /* Add vertical lines between table columns */
  .table th, .table td {
      border-left: 1px solid #dee2e6; /* Light gray vertical lines */
      border-right: 1px solid #dee2e6;
  }

  .table th:first-child, .table td:first-child {
      border-left: none; /* No left border for the first column */
  }

  .table th:last-child, .table td:last-child {
      border-right: none; /* No right border for the last column */
  }

  /* Ensure message and address columns have the same width */
  .table td:nth-child(5), .table th:nth-child(5), 
  .table td:nth-child(6), .table th:nth-child(6) {
      width: 20%; /* Adjust the percentage as needed */
      word-wrap: break-word; /* Ensures content wraps inside the cell */
  }

  /* Fix sorting arrows for better visibility */
  th.sorting::after, th.sorting_asc::after, th.sorting_desc::after {
    font-family: FontAwesome;
    content: "\f0dc"; /* Default sorting icon */
    padding-left: 8px;
    opacity: 0.6;
  }

  th.sorting_asc::after {
    content: "\f0de"; /* Ascending arrow */
  }

  th.sorting_desc::after {
    content: "\f0dd"; /* Descending arrow */
  }
</style>
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- DataTables Bootstrap Integration -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
    <h1>Archived Reports</h1>
    <table class="table display">
        <thead>
            <tr>
                <th>#</th>
                <th>Date Created</th>
                <th>Code</th>
                <th>Reported By</th>
                <th>Message</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            while ($row = $qry->fetch_assoc()) {
                // Combine lastname, firstname, middlename, and contact
                $reported_by = $row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . '<br>' . ' ' . $row['contact'] . '</small>';
                // Combine subject and message with subject on top and message below
                $subject_message = "Subject: " . $row['subject'] . "<br>" . $row['message'];
                // Combine sitio_street, barangay, and municipality for address
                $address = $row['sitio_street'] . ', ' . $row['barangay'] . ', ' . $row['municipality'];

                echo '<tr>';
                echo '<td>' . $i++ . '</td>';
                echo '<td>' . $row['date_created'] . '</td>';
                echo '<td>' . $row['code'] . '</td>';
                echo '<td>' . $reported_by . '</td>';
                echo '<td>' . $subject_message . '</td>';
                echo '<td>' . $address . '</td>';
                echo '<td>
                        <a class="dropdown-item restore_data" href="javascript:void(0)" data-id="' . $row['id'] . '">
                            <span class="fa fa-undo text-success"></span> Restore
                        </a>
                        <a class="dropdown-item delete_permanently" href="javascript:void(0)" data-id="' . $row['id'] . '">
                            <span class="fa fa-trash text-danger"></span> Delete Permanently
                        </a>
                    </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <script>
    $(document).ready(function(){
    $('.restore_data').click(function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to restore this request?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                restore_request(id);
            }
        });
    });

    $('.delete_permanently').click(function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone. Do you want to permanently delete this request?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                delete_permanently(id);
            }
        });
    });

    $('.table').DataTable({
        columnDefs: [
            { orderable: false, targets: [6] } // Adjust index for action column
        ],
        order:[0,'asc']
    });

    $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle');
});

function delete_permanently(id) {
    $.ajax({
        url: _base_url_ + 'classes/Master.php?f=delete_permanently',
        method: 'POST',
        data: { id: id },
        dataType: 'json',
        beforeSend: function() {
            start_loader();
        },
        success: function(resp) {
            end_loader();
            if (resp.status === 'success') {
                Swal.fire('Deleted!', 'The request has been permanently deleted.', 'success').then(() => {
                    location.reload(); // Refresh to show changes
                });
            } else {
                Swal.fire('Failed!', 'An error occurred while deleting.', 'error');
            }
        },
        error: function() {
            Swal.fire('Failed!', 'An error occurred while deleting.', 'error');
            end_loader();
        }
    });
}
    </script>
</body>
</html>
