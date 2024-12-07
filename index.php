<?php
session_start();
require_once('config.php');

// Prevent caching of the page to avoid back button issues
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Check if user role is already set, otherwise redirect to gateway
if (!isset($_SESSION['role'])) {
    header("Location: ./login.php"); // Redirect to the new gateway page
    exit; // Ensure no further code is executed
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>

<?php if ($_settings->chk_flashdata('success')): ?>
<script>
  $(function(){
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
  })
</script>
<?php endif; ?>

<body>
<?php require_once('inc/topBarNav.php') ?>

<?php 
    // Determine the page to include, default to 'home' if not provided
    $page = isset($_GET['p']) ? $_GET['p'] : 'home';  

    // Check if the requested page exists, include the corresponding page or show a 404 error
    if (!file_exists($page . ".php") && !is_dir($page)) {
        include '404.html';
    } else {
        if (is_dir($page)) {
            include $page . '/index.php';
        } else {
            include $page . '.php';
        }
    }
?>

<?php require_once('inc/footer.php') ?>

<!-- Modal for displaying forms or data -->
<div class="modal fade" id="uni_modal" role='dialog'>
  <div class="modal-dialog rounded-0 modal-md modal-dialog-centered" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for right-side view -->
<div class="modal fade" id="uni_modal_right" role='dialog'>
  <div class="modal-dialog rounded-0 modal-full-height modal-md" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<!-- Modal for viewing images -->
<div class="modal fade" id="viewer_modal" role='dialog'>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
      <img src="" alt="">
    </div>
  </div>
</div>

<!-- Modal for confirmation actions -->
<div class="modal fade" id="confirm_modal" role='dialog'>
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
