<?php
require_once 'db.php';
require_once 'functions.php';

// Check if the Pay button is submitted
if (isset($_POST['pay'])) {
    // Retrieve the form data
    $billId = $_POST['billId'];
    $paidAmount = $_POST['paidAmount'];
    $notes = $_POST['notes'];

    // Get the current date and time
    $paidDate = date('Y-m-d H:i:s');

    // Create an array with the form data
    $data = array(
        'billId' => $billId,
        'paidAmount' => $paidAmount,
        'paidDate' => $paidDate,
        'notes' => $notes
    );

    // Call the saveBillData function to update the database
    $result = saveBillData($data);

    // Send response to the client
    if ($result) {
        echo "Bill updated successfully.";
    } else {
        echo "Failed to update bill.";
    }
}
?>
