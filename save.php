<?php
// Include the functions file
include "functions.php";

// Check if the amount is set and not empty
if (isset($_POST['amount']) && !empty($_POST['amount'])) {
  // Get the amount from the POST data
  $amount = $_POST['amount'];

  // Save the data and get the result
  $result = saveData($amount);

  // Return the result as JSON
  echo json_encode($result);
}
?>
