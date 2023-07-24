<?php
// get_bill.php

require_once 'db.php';
require_once 'functions.php';

// Check if the bill ID is provided

if (isset($_POST['billId'])) {
  $billId = $_POST['billId'];

  // Retrieve the bill data from the database
  $bill = getBillFromDatabase($billId);

  if ($bill) {
    // Return the bill data as JSON
    echo json_encode($bill);
  } else {
    // Handle the case when the bill is not found
    echo json_encode(['error' => 'Bill not found']);
  }
} else {
  // Handle the case when the bill ID is not provided
  echo json_encode(['error' => 'Invalid request']);
}
?>
