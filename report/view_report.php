<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `request_list` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
    if (isset($team_id) && $team_id > 0) {
        $team_qry = $conn->query("SELECT * FROM `team_list` where id = '{$team_id}'");
        if ($team_qry->num_rows > 0) {
            $res = $team_qry->fetch_array();
            foreach ($res as $k => $v) {
                if (!is_numeric($k)) {
                    $team[$k] = $v;
                }
            }
        }
    }
}
?>
<style>
    /* General Styling */
    body {
        padding: 10px;
        margin-top: 40px;
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    /* Header and Section Titles */
    .content {
        background-color: #ff4600;
        color: #fff;
        padding: 1.5rem;
        border-radius: 5px 5px 0 0;
        text-align: center;
    }

    /* Card and Container */
    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .card-header {
        background-color: #343a40;
        color: #fff;
        font-weight: bold;
        padding: 0.75rem 1.25rem;
        border-radius: 8px 8px 0 0;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Table Styling */
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table th {
        background-color: #343a40;
        color: #fff;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    /* Image Styling */
    #request-logo {
        max-width: 100%;
        max-height: 20em;
        object-fit: scale-down;
        object-position: center center;
    }

    /* Responsive Design for Mobile */
    @media (max-width: 768px) {
        .content h2 {
            font-size: 1.5rem;
        }

        /* Responsive Card Layout */
        .d-flex {
            flex-direction: column !important;
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
            padding: 0.75rem;
            position: relative;
        }

        .table td::before {
            content: attr(data-label);
            font-weight: bold;
            display: inline-block;
            width: 50%;
            color: #343a40;
        }
    }
</style>

<section class="py-3">
    <div class="container">
        <div class="content">
            <h2><b><?= isset($code) ? $code : '' ?> Request</b></h2>
        </div>
        <div class="row flex-column mt-4 justify-content-center align-items-center">
            <!-- Request Details Card -->
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card">
                    <div class="card-header">Request Details</div>
                    <div class="card-body">
                        <div class="d-flex w-100 mb-2">
                            <div class="col-auto pr-1">Request Code:</div>
                            <div class="col-auto flex-grow-1 font-weight-bold"><?= isset($code) ? $code : '' ?></div>
                        </div>
                        <div class="d-flex w-100 mb-2">
                            <div class="col-auto pr-1">Request Date & Time:</div>
                            <div class="col-auto flex-grow-1 font-weight-bold"><?= isset($date_created) ? date('M d, Y h:i A', strtotime($date_created)) : '' ?></div>
                        </div>
                        <div class="d-flex w-100 mb-2">
                            <div class="col-auto pr-1">Reported By:</div>
                            <div class="col-auto flex-grow-1 font-weight-bold">
                                <?= isset($lastname) && isset($firstname) && isset($middlename) ? "{$lastname}, {$firstname} {$middlename}" : '' ?>
                            </div>
                        </div>
                        <div class="d-flex w-100 mb-2">
                            <div class="col-auto pr-1">Contact #:</div>
                            <div class="col-auto flex-grow-1 font-weight-bold"><?= isset($contact) ? $contact : '' ?></div>
                        </div>
                        <div class="d-flex w-100 mb-2">
                            <div class="col-auto pr-1">Subject:</div>
                            <div class="col-auto flex-grow-1 font-weight-bold"><?= isset($subject) ? $subject : '' ?></div>
                        </div>
                        <div class="d-flex w-100 mb-2">
                            <div class="col-auto pr-1">Message:</div>
                            <div class="col-auto flex-grow-1 font-weight-bold"><?= isset($message) ? nl2br($message) : '' ?></div>
                        </div>
                        <div class="d-flex w-100 mb-2">
                            <div class="col-auto pr-1">Address:</div>
                            <div class="col-auto flex-grow-1 font-weight-bold">
                                <?= isset($sitio_street) && isset($barangay) && isset($municipality) ? "{$sitio_street}, {$barangay}, {$municipality}" : '' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Team Details Card -->
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card">
                    <div class="card-header">Assigned Team Details</div>
                    <div class="card-body">
                        <?php if (isset($team_id) && $team_id > 0): ?>
                            <div class="d-flex w-100 mb-2">
                                <div class="col-auto pr-1">Team Code:</div>
                                <div class="col-auto flex-grow-1 font-weight-bold"><?= isset($team['code']) ? $team['code'] : '' ?></div>
                            </div>
                            <div class="d-flex w-100 mb-2">
                                <div class="col-auto pr-1">Team Leader:</div>
                                <div class="col-auto flex-grow-1 font-weight-bold"><?= isset($team['leader_name']) ? $team['leader_name'] : '' ?></div>
                            </div>
                            <div class="d-flex w-100 mb-2">
                                <div class="col-auto pr-1">Team Leader Contact #:</div>
                                <div class="col-auto flex-grow-1 font-weight-bold"><?= isset($team['leader_contact']) ? $team['leader_contact'] : '' ?></div>
                            </div>
                            <div class="d-flex w-100 mb-2">
                                <div class="col-auto pr-1">Team Members:</div>
                                <div class="col-auto flex-grow-1 font-weight-bold"><?= isset($team['members']) ? nl2br($team['members']) : '' ?></div>
                            </div>
                        <?php else: ?>
                            <h5 class="text-center text-muted">No team assigned yet.</h5>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Action History Card -->
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card">
                    <div class="card-header">Action History</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <colgroup>
                                <col width="30%">
                                <col width="30%">
                                <col width="40%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Date Action Taken</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (isset($id)):
                                    $history = $conn->query("SELECT * FROM `history_list` where request_id = '{$id}' order by abs(unix_timestamp(date_created)) asc");
                                    while ($row = $history->fetch_assoc()):
                                ?>
                                <tr>
                                    <td data-label="Date Action Taken"><?= date("M d, Y h:i A", strtotime($row['date_created'])) ?></td>
                                    <td data-label="Status"><?= ["Pending", "Assigned to Team", "Team is on their way", "Relief on Progress", "Relief Completed"][$row['status']] ?? 'N/A' ?></td>
                                    <td data-label="Remarks"><?= $row['remarks'] ?></td>
                                </tr>
                                <?php endwhile; ?>
                                <?php if ($history->num_rows <= 0): ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No records found</td>
                                    </tr>
                                <?php endif; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
