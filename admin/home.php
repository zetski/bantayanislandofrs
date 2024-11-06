<?php
// Assuming $_settings->userdata('district') holds the admin's district
$admin_district = $_settings->userdata('district');

// Query to count teams where the district matches the admin's district
$team_query = $conn->query("SELECT * FROM team_list WHERE delete_flag = 0 AND district = '{$admin_district}'");
$team_count = $team_query->num_rows;

// Define an array with historical data for past months.
// Replace this array with the actual historical data if stored in the database
$monthly_data = [12, 19, 3, 5, 2, 3, 9, 0]; // Example data from January to August based on the chart

// Calculate data for the remaining months (September to December)
$current_month = date('n'); // Current month as a number (1-12)
for ($month = count($monthly_data) + 1; $month <= 12; $month++) {
    if ($month > $current_month) {
        // For future months, add 0 or omit if no future data is expected
        $monthly_data[] = 0;
    } else {
        $start_date = date('Y') . "-$month-01";
        $end_date = date('Y-m-t', strtotime($start_date));
        $count = $conn->query("SELECT COUNT(id) FROM request_list WHERE municipality = '{$admin_district}' AND date_created BETWEEN '$start_date' AND '$end_date'")->fetch_row()[0];
        $monthly_data[] = $count;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Latest Bootstrap 5.3.0 CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    .info-box {
      display: flex;
      align-items: center;
      padding: 15px;
      margin-bottom: 15px;
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: .25rem;
    }
    .info-box-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      font-size: 24px;
      background-color: #e9ecef;
    }
    .info-box-content {
      flex: 1;
      margin-left: 15px;
    }
    .chart-container {
    position: relative;
    height: 100%;
    width: 100%;
    background: linear-gradient(to bottom right, #f0f4ff, #e3ebff);
    border-radius: 15px;
    padding: 15px;
  }
  
  canvas {
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    padding: 15px;
  }

  /* Customize the tooltips */
  .chartjs-tooltip {
    background-color: rgba(0, 0, 0, 0.7);
    border-radius: 5px;
    color: white;
    padding: 5px;
  }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">
  <div class="container my-3 flex-grow-1">
    <h3 style="display: inline-block; margin-right: 20px;">
      Welcome, <?php echo $_settings->userdata('firstname')." ".$_settings->userdata('lastname') ?>!
    </h3>
    <div class="row h-100">
    <div class="col-12 col-sm-4 col-md-4 mb-3 h-100">
    <a href="./?page=teams" class="text-decoration-none h-100 d-block">
        <div class="info-box h-100 d-flex flex-column justify-content-center">
            <span class="info-box-icon bg-gradient-secondary">
                <i class="fas fa-users"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Control Teams</span>
                <span class="info-box-number text-center h5">
                    <?php 
                        // Display the filtered team count
                        echo format_num($team_count);
                    ?>
                </span>
            </div>
        </div>
    </a>
</div>

<div class="col-12 col-sm-4 col-md-4 mb-3 h-100">
  <a href="./?page=requests&status=0" class="text-decoration-none h-100 d-block">
    <div class="info-box h-100 d-flex flex-column justify-content-center">
      <span class="info-box-icon bg-gradient-secondary">
        <i class="fas fa-hourglass-half"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Pending Requests</span>
        <span class="info-box-number text-center h5">
          <?php 
            // Include district filter for pending requests
            $pending_requests = $conn->query("SELECT id FROM request_list WHERE status = 0 AND municipality = '{$admin_district}'")->num_rows;
            echo format_num($pending_requests);
          ?>
        </span>
      </div>
    </div>
  </a>
</div>

<div class="col-12 col-sm-4 col-md-4 mb-3 h-100">
  <a href="./?page=requests&status=1" class="text-decoration-none h-100 d-block">
    <div class="info-box h-100 d-flex flex-column justify-content-center">
      <span class="info-box-icon bg-gradient-secondary">
        <i class="fas fa-tasks"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Assigned Requests</span>
        <span class="info-box-number text-center h5">
          <?php 
            // Include district filter for assigned requests
            $assigned_requests = $conn->query("SELECT id FROM request_list WHERE status = 1 AND municipality = '{$admin_district}'")->num_rows;
            echo format_num($assigned_requests);
          ?>
        </span>
      </div>
    </div>
  </a>
</div>

<div class="col-12 col-sm-4 col-md-4 mb-3 h-100">
  <a href="./?page=requests&status=2" class="text-decoration-none h-100 d-block">
    <div class="info-box h-100 d-flex flex-column justify-content-center">
      <span class="info-box-icon bg-gradient-secondary">
        <i class="fas fa-truck"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Team OTW Requests</span>
        <span class="info-box-number text-center h5">
          <?php 
            // Include district filter for OTW requests
            $otw_requests = $conn->query("SELECT id FROM request_list WHERE status = 2 AND municipality = '{$admin_district}'")->num_rows;
            echo format_num($otw_requests);
          ?>
        </span>
      </div>
    </div>
  </a>
</div>

<div class="col-12 col-sm-4 col-md-4 mb-3 h-100">
  <a href="./?page=requests&status=3" class="text-decoration-none h-100 d-block">
    <div class="info-box h-100 d-flex flex-column justify-content-center">
      <span class="info-box-icon bg-gradient-secondary">
        <i class="fas fa-wrench"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">On-Progress Requests</span>
        <span class="info-box-number text-center h5">
          <?php 
            // Include district filter for on-progress requests
            $in_progress_requests = $conn->query("SELECT id FROM request_list WHERE status = 3 AND municipality = '{$admin_district}'")->num_rows;
            echo format_num($in_progress_requests);
          ?>
        </span>
      </div>
    </div>
  </a>
</div>

<div class="col-12 col-sm-4 col-md-4 mb-3 h-100">
  <a href="./?page=requests&status=4" class="text-decoration-none h-100 d-block">
    <div class="info-box h-100 d-flex flex-column justify-content-center">
      <span class="info-box-icon bg-gradient-secondary">
        <i class="fas fa-check"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Completed Requests</span>
        <span class="info-box-number text-center h5">
          <?php 
            // Include district filter for completed requests
            $completed_requests = $conn->query("SELECT id FROM request_list WHERE status = 4 AND municipality = '{$admin_district}'")->num_rows;
            echo format_num($completed_requests);
          ?>
        </span>
      </div>
    </div>
  </a>
</div>
    </div>
    <div class="row">
      <div class="col-12 col-md-6">
        <canvas id="barChart"></canvas>
      </div>
      <div class="col-12 col-md-6">
        <canvas id="lineChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Latest Bootstrap 5.3.0 JS and Popper.js -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <script>
// Data for the bar chart
var barData = {
  labels: ["Teams", "Pending Requests", "Assigned Requests", "OTW Requests", "On-Progress Requests", "Completed Requests"],
  datasets: [{
    label: 'Number of Requests',
    data: [
      <?php echo $team_count; ?>, // Corrected team count remains as is
      <?php echo $conn->query("SELECT COUNT(id) FROM request_list WHERE status = 0 AND municipality = '{$admin_district}'")->fetch_row()[0]; ?>,
      <?php echo $conn->query("SELECT COUNT(id) FROM request_list WHERE status = 1 AND municipality = '{$admin_district}'")->fetch_row()[0]; ?>,
      <?php echo $conn->query("SELECT COUNT(id) FROM request_list WHERE status = 2 AND municipality = '{$admin_district}'")->fetch_row()[0]; ?>,
      <?php echo $conn->query("SELECT COUNT(id) FROM request_list WHERE status = 3 AND municipality = '{$admin_district}'")->fetch_row()[0]; ?>,
      <?php echo $conn->query("SELECT COUNT(id) FROM request_list WHERE status = 4 AND municipality = '{$admin_district}'")->fetch_row()[0]; ?>
    ],
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)',
      'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 1
  }]
};

var lineData = {
    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    datasets: [{
        label: 'Requests Over Time',
        data: <?php echo json_encode($monthly_data); ?>, // PHP-generated monthly data, including past data
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        fill: true
    }]
};

  var barConfig = {
    type: 'bar',
    data: barData,
    options: {
      plugins: {
        legend: {
          display: true,
          position: 'top',
          labels: {
            color: '#333',
            font: {
              size: 14
            }
          }
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.7)',
          titleColor: '#fff',
          bodyColor: '#fff',
          borderColor: '#fff',
          borderWidth: 1
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(200, 200, 200, 0.2)'
          },
          ticks: {
            color: '#666',
            font: {
              size: 12
            }
          }
        },
        x: {
          grid: {
            display: false
          },
          ticks: {
            color: '#666',
            font: {
              size: 12
            }
          }
        }
      },
      elements: {
        bar: {
          borderRadius: 5
        }
      }
    }
  };

  var lineConfig = {
    type: 'line',
    data: lineData,
    options: {
      plugins: {
        legend: {
          display: true,
          position: 'top',
          labels: {
            color: '#333',
            font: {
              size: 14
            }
          }
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.7)',
          titleColor: '#fff',
          bodyColor: '#fff',
          borderColor: '#fff',
          borderWidth: 1
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(200, 200, 200, 0.2)'
          },
          ticks: {
            color: '#666',
            font: {
              size: 12
            }
          }
        },
        x: {
          grid: {
            display: false
          },
          ticks: {
            color: '#666',
            font: {
              size: 12
            }
          }
        }
      },
      elements: {
        line: {
          tension: 0.4,
          borderWidth: 3
        },
        point: {
          radius: 4,
          backgroundColor: '#fff',
          borderWidth: 2
        }
      }
    }
  };
  
  // Initialize the charts
  var barChart = new Chart(document.getElementById('barChart'), barConfig);
  var lineChart = new Chart(document.getElementById('lineChart'), lineConfig);
</script>

</body>
</html>