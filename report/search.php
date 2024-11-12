<style>
    /* Style adjustments for the modal footer */
    #uni_modal .modal-footer {
        display: none !important;
    }
</style>

<div class="container-fluid">
    <form action="" id="search-report">
        <div class="form-group">
            <label for="search" class="control-label">Search by (Request Code, Name, or Contact #)</label>
            <input type="text" class="form-control form-control-sm rounded-0" name="search" id="search" placeholder="Enter your search term here">
        </div>
    </form>
</div>

<hr class="mx-n3">

<div class="px-2 text-center">
    <button class="btn btn-flat btn-sm btn-primary bg-gradient-primary" form="search-report">
        <i class="fa fa-search"></i> Search
    </button>
    <button class="btn btn-flat btn-sm btn-light bg-gradient-light border" type="button" data-dismiss="modal">
        <i class="fa fa-times"></i> Cancel
    </button>
</div>

<script>
    $(function() {
        // Sanitize the input by removing special characters
        $('#search').on('input', function () {
            let sanitized = $(this).val().replace(/[<>\/]/g, ''); // Remove <, >, and / characters
            sanitized = sanitized.replace(/script/gi, ''); // Remove any case variation of "script"
            $(this).val(sanitized);
        });

        // Handle form submission
        $('#search-report').submit(function(e) {
            e.preventDefault(); // Prevent default form submission behavior

            let searchQuery = $('#search').val().trim(); // Get the search input value and remove extra spaces

            if (searchQuery) {
                // Redirect to the results page with search parameters
                location.href = `./?p=report/list&search=${encodeURIComponent(searchQuery)}`;
            } else {
                alert('Please enter a search term.');
            }
        });
    });
</script>
