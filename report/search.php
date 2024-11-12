<style>
    #uni_modal .modal-footer {
        display: none !important;
    }

    /* Styling for the running text */
    #runningTextContainer {
        position: relative;
        margin-bottom: 10px; /* Space between running text and search form */
    }

    #runningText {
        width: 100%;
        overflow: hidden;
        white-space: nowrap;
        font-size: 1rem;
        color: #343a40;
        background-color: #ffebb7;
        padding: 10px;
        font-weight: bold;
        text-align: center;
        position: relative;
        z-index: 10; /* Ensures it stays on top of other modal content */
    }

    .marquee {
        display: inline-block;
        animation: scroll 15s linear infinite;
    }

    @keyframes scroll {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(-100%);
        }
    }
</style>

<!-- Running Text Background for Modal -->
<div id="runningTextContainer">
    <div id="runningText">
        <span id="marqueeText" class="marquee">
            <!-- The text content will be dynamically updated -->
        </span>
    </div>
</div>

<div class="container-fluid">
    <form action="" id="search-report">
        <div class="form-group">
            <label for="search" class="control-label">Search by (Request Code, Name, or Contact #)</label>
            <input type="text" class="form-control form-control-sm rounded-0" name="search" id="search">
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
    function loadRunningText() {
        // Example data - replace with actual AJAX fetch for dynamic content
        let reportDetails = {
            date_created: '<?= isset($date_created) ? date("M d, Y h:i A", strtotime($date_created)) : "" ?>',
            code: '<?= isset($code) ? $code : "" ?>',
            reported_by: '<?= isset($lastname) && isset($firstname) && isset($middlename) ? "{$lastname}, {$firstname} {$middlename}" : "" ?>',
            address: '<?= isset($sitio_street) && isset($barangay) && isset($municipality) ? "{$sitio_street}, {$barangay}, {$municipality}" : "" ?>',
            status_update: 'Team is on their way' // Dynamic status can be fetched
        };

        // Update marquee content
        let runningTextContent = `Report Code: ${reportDetails.code} | Date: ${reportDetails.date_created} | Reported by: ${reportDetails.reported_by} | Address: ${reportDetails.address} | Update: ${reportDetails.status_update}`;
        document.getElementById('marqueeText').textContent = runningTextContent;
    }

    $(document).ready(function() {
        $('#search_report, #search_report_sidebar').click(function() {
            loadRunningText(); // Load text when modal opens
            uni_modal("Search Request Report", "report/search.php");
        });
    });
</script>

