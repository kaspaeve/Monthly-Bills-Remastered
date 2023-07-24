<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'db.php';
require_once 'functions.php';

// Check if the action parameter is set
if (isset($_POST['action']) && $_POST['action'] === 'payBill') {
    // Check if the required parameters are set
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
} else {
    echo 'error';
}
?>
