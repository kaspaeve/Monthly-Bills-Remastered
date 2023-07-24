<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $billId = $_POST['billId'];
    $amountPaid = $_POST['amountPaid'];

    // Sanitize and validate input
    $billId = filter_var($billId, FILTER_SANITIZE_NUMBER_INT);
    $amountPaid = filter_var($amountPaid, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if (!is_numeric($billId) || !is_numeric($amountPaid)) {
        echo 'error';
        exit;
    }

    if (updateBillPaidAmount($billId, $amountPaid)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
