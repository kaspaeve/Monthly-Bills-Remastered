<?php
//ajax.php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'db.php';
require_once 'functions.php';

// Check if the action parameter is set
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'payBill') {
        // Handle the payBill action
        if (isset($_POST['billId']) && isset($_POST['paidAmount'])) {
            $billId = $_POST['billId'];
            $paidAmount = $_POST['paidAmount'];

            // Call the function to update the bill_paid_amount
            $result = updateBillPaidAmount($billId, $paidAmount);

            if ($result) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    } elseif ($action === 'viewBills') {
        // Handle the viewBills action
        if (isset($_POST['month']) && isset($_POST['year'])) {
            $month = $_POST['month'];
            $year = $_POST['year'];

            // Fetch bills based on the provided month and year
            $bills = fetchBills($month, $year);

            // Return the bills as a JSON response
            echo json_encode($bills);
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>
