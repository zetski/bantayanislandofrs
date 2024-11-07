<head>
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'; style-src 'self';">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
</head>

<style>
    #uni_modal .modal-footer {
        display: none !important;
    }
</style>

<div class="container-fluid">
    <form action="" id="search-report">
        <div class="form-group">
            <label for="search" class="control-label">Search by (Request Code, Name, or Contact #)</label>
            <!-- Alphanumeric only pattern -->
            <input type="text" class="form-control form-control-sm rounded-0" name="search" id="search" 
                pattern="^[a-zA-Z0-9 ]*$" title="Only letters, numbers, and spaces are allowed." 
                autocomplete="off" required>
        </div>
    </form>
</div>

<hr class="mx-n3">

<div class="px-2 text-center">
    <button class="btn btn-flat btn-sm btn-primary bg-gradient-primary" form="search-report"><i class="fa fa-search"></i> Search</button>
    <button class="btn btn-flat btn-sm btn-light bg-gradient-light border" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
</div>

<script>
    // Disable paste to prevent pasting restricted characters
    document.getElementById("search").addEventListener("paste", (e) => e.preventDefault());

    $(function() {
        $('#search-report').submit(function(e) {
            e.preventDefault();
            const searchInput = $('#search').val();

            // Validate against any non-alphanumeric characters
            const forbiddenPattern = /[^a-zA-Z0-9 ]/;
            if (forbiddenPattern.test(searchInput)) {
                alert("Invalid input detected. Only letters, numbers, and spaces are allowed.");
                return;
            }

            // If input is safe, proceed with form submission
            location.href = "./?p=report/list&" + $(this).serialize();
        });
    });
</script>
