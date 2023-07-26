<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';
require_once 'functions.php';
if (isset($_POST['generatereport'])) {
    $year = $_POST['year'];
    $month = $_POST['month'];
} else {
    $year = $_GET['year'];
    $month = $_GET['month'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bill Management System</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Fifth navbar example">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Monthly Bills</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample05">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Add Bill</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Add Monthly Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="bill_list.php">List Bills</a>
                    </li>
                </ul>
            </div>
            <form role="search">
                <input class="form-control" type="search" placeholder="Search site" aria-label="Search">
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <h1>Bill Management System</h1>
        <hr>

        <div class="row">
            <div class="col-md-6 mx-auto">
                <h4>View Bills</h4>
                <div class="form-group">
                    <label for="month">Month</label>
                    <select id="month" class="form-control">
                        <option value="">-- Select Month --</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="year">Year</label>
                    <select id="year" class="form-control">
                        <option value="">-- Select Year --</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
                <button id="view-btn" class="btn btn-primary btn-view">View</button>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="table-container">
                    <table id="bills-table" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                                <th>Amount Paid</th>
                                <th>Due Date</th>
                                <th>Date Paid</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Bill data will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for entering payment -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Enter Payment and Notes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bill-name">Bill Name:</label>
                        <input type="text" class="form-control" id="bill-name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="bill-amount">Amount:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control" id="bill-amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bill-notes">Notes:</label>
                        <textarea class="form-control" id="bill-notes"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="pay-btn">Pay</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
  <script src="script.js"></script>



</body>
</html>
