<style>
    /* General Styling */
    body {
        padding-top: 10px;
        margin-top: 40px;
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    /* Section Header Styling */
    .content {
        background-color: #ff4600;
        color: #fff;
        padding: 1.5rem;
        border-radius: 5px 5px 0 0;
        text-align: center;
    }

    /* Card and Table Styling */
    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 1rem 1.5rem;
    }

    /* Table Styling */
    .table {
        font-size: 0.9rem;
    }

    .table th, .table td {
        vertical-align: middle;
        padding: 0.75rem;
        text-align: center;
    }

    .table th {
        background-color: #343a40;
        color: #fff;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    /* Button Styling */
    .btn-light {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        transition: background-color 0.3s ease;
    }

    .btn-light:hover {
        background-color: #e2e6ea;
    }

    .btn-light .fa-eye {
        color: #ff4600;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .content h2 {
            font-size: 1.5rem;
        }

        .table thead {
            display: none;
        }

        .table, .table tbody, .table tr, .table td {
            display: block;
            width: 100%;
        }

        .table td {
            text-align: left;
            padding: 0.75rem 1rem;
            position: relative;
        }

        .table td::before {
            content: attr(data-label);
            font-weight: bold;
            display: inline-block;
            width: 50%;
            color: #343a40;
        }

        .card {
            margin-top: 1rem;
        }
    }
</style>

<section class="py-3">
    <div class="container">
        <div class="content">
            <h2>Search Result against '<?= $_GET['search'] ?>'</h2>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-lg-11 col-md-11 col-sm-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="container-fluid">
                            <table class="table table-hover table-striped table-bordered" id="list">
                                <colgroup>
                                    <col width="5%">
                                    <col width="20%">
                                    <col width="15%">
                                    <col width="20%">
                                    <col width="25%">
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(isset($_GET['search'])):
                                    $i = 1;
                                    $qry = $conn->query("SELECT *, CONCAT(lastname, ', ', firstname, ' ', middlename, ' ',contact) as reported_by, 
                                    CONCAT(sitio_street, ', ', barangay, ', ', municipality) as address 
                                    from `request_list` 
                                    where (lastname LIKE '%{$_GET['search']}%' or firstname LIKE '%{$_GET['search']}%' or middlename LIKE '%{$_GET['search']}%' or contact LIKE '%{$_GET['search']}%' or code LIKE '%{$_GET['search']}%') 
                                    order by abs(unix_timestamp(date_created)) desc ");
                                        while($row = $qry->fetch_assoc()):
                                    ?>
                                        <tr>
                                            <td data-label="#"> <?php echo $i++; ?> </td>
                                            <td data-label="Date Created"> <?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?> </td>
                                            <td data-label="Code"> <?php echo $row['code'] ?> </td>
                                            <td data-label="Reported By"> <?php echo $row['reported_by'] ?> </td>
                                            <td data-label="Message">
                                                <strong>Subject:</strong> <?php echo $row['subject'] ?><br>
                                                <?php echo $row['message'] ?>
                                            </td>
                                            <td data-label="Address"> <?php echo $row['address'] ?> </td>
                                            <td data-label="Action">
                                                <a href="./?p=report/view_report&id=<?= $row['id'] ?>" class="btn btn-flat btn-sm btn-light bg-gradient-light border">
                                                    <i class="fa fa-eye text-dark"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(function(){
        $('#list').find('th, td').addClass('py-1 px-2 align-middle')
    })
</script>
