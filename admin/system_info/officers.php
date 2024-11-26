<?php
require_once('../config.php');

// Fetch officers from the database
$officers = $conn->query("SELECT * FROM `officers` ORDER BY `lastname`, `firstname` ASC");

?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Officers Management</h3>
        <div class="card-tools">
            <a href="./?page=officers/manage_officer" class="btn btn-flat btn-primary">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Full Name</th>
                    <th>Rank/Position</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $officers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <img src="<?php echo validate_image($row['image']); ?>" alt="Officer Image" class="img-thumbnail" style="width: 50px; height: 50px;">
                    </td>
                    <td><?php echo $row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename']; ?></td>
                    <td><?php echo $row['position']; ?></td>
                    <td>
                        <a href="./?page=officers/manage_officer&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="./?page=officers/delete_officer&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
