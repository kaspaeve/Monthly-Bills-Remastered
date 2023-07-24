<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php'; // Include the file containing database configuration

// Function to load SQL data based on month and year
function getBillsByMonthAndYear($month, $year)
{
    global $pdo; // Access the database connection object

    // Sanitize and validate input
    $month = filter_var($month, FILTER_SANITIZE_STRING);
    $year = filter_var($year, FILTER_VALIDATE_INT);

    if ($month === false || $year === false) {
        return array(); // Invalid input, return empty array
    }

    try {
        // Prepare the select query
        $stmt = $pdo->prepare("SELECT * FROM history WHERE Month = :month AND Year = :year");

        // Bind the parameters
        $stmt->bindParam(':month', $month, PDO::PARAM_STR);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch all rows
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        // Handle database error
        die("Error retrieving bills: " . $e->getMessage());
    }
}

// Function to save data in the SQL database
function saveBillData($data)
{
    global $pdo; // Access the database connection object

    // Sanitize and validate input
    $id = filter_var($data['billId'], FILTER_VALIDATE_INT);
    $paidAmount = filter_var($data['paidAmount'], FILTER_VALIDATE_FLOAT);


    if ($id === false || $paidAmount === false) {
        return false; // Invalid input, return false
    }

    // Get the current date/time
    $paidDate = date('Y-m-d H:i:s');

    try {
        // Prepare the update query
        $stmt = $pdo->prepare("UPDATE history SET bill_paid_amount = :paidAmount, bill_paid_date = :paidDate WHERE b_id = :id");

        // Bind the parameters
        $stmt->bindParam(':paidAmount', $paidAmount, PDO::PARAM_STR);
        $stmt->bindParam(':paidDate', $paidDate, PDO::PARAM_STR);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        return true; // Data saved successfully
    } catch (PDOException $e) {
        // Handle database error
        die("Error saving bill data: " . $e->getMessage());
    }
}

// Function to retrieve unique months from the database
function getMonths()
{
    global $pdo; // Access the database connection object

    try {
        $stmt = $pdo->query("SELECT DISTINCT Month FROM history");
        $months = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $months;
    } catch (PDOException $e) {
        die("Error retrieving months: " . $e->getMessage());
    }
}

// Function to retrieve unique years from the database
function getYears($startYear, $endYear)
{
    $years = range($startYear, $endYear);
    return $years;
}

// Function to retrieve database status
function getDatabaseStatus()
{
    global $pdo; // Access the $pdo variable defined in db.php

    try {
        $pdo->query("SELECT 1");
        return "Connected"; // Database connection successful
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage(); // Database connection error
    }
}

// Add any other functions you have in function.php

// Sanitize user input to prevent SQL injection attacks
function sanitizeInput($input)
{
    return str_replace(array('<', '>'), array('&lt;', '&gt;'), $input);
}

// Validate user input to prevent SQL injection attacks
function validateInput($input)
{
    return preg_match('/^[a-zA-Z0-9\s]+$/', $input);
}

// Function to fetch bill data based on month and year
// Function to fetch bill data based on month and year
function fetchBills($month, $year)
{
    global $pdo; // Access the database connection object

    // Sanitize and validate input
    $month = filter_var($month, FILTER_SANITIZE_STRING);
    $year = filter_var($year, FILTER_VALIDATE_INT);

    if ($month === false || $year === false) {
        return json_encode(array()); // Invalid input, return empty JSON array
    }

    try {
        // Prepare the select query
        $stmt = $pdo->prepare("SELECT * FROM history WHERE Month = :month AND Year = :year");

        // Bind the parameters
        $stmt->bindParam(':month', $month, PDO::PARAM_STR);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch all rows
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the result as JSON
        echo json_encode($result);
        exit;
    } catch (PDOException $e) {
        // Handle database error
        die("Error fetching bill data: " . $e->getMessage());
    }
}

// Function to fetch bill details by b_id
function getBillByBId($bId)
{
    global $pdo; // Access the database connection object

    // Sanitize and validate input
    $bId = filter_var($bId, FILTER_VALIDATE_INT);

    if ($bId === false) {
        return json_encode(array()); // Invalid input, return empty JSON array
    }

    try {
        // Prepare the select query
        $stmt = $pdo->prepare("SELECT * FROM history WHERE b_id = :bId");

        // Bind the parameter
        $stmt->bindParam(':bId', $bId, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the row
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return json_encode($result); // Convert the result to JSON and return
    } catch (PDOException $e) {
        // Handle database error
        die("Error fetching bill details: " . $e->getMessage());
    }
}

// Function to update bill paid amount and date
function updateBillPaidAmount($billId, $paidAmount)
{
    global $pdo; // Access the database connection object

    // Sanitize and validate input
    $billId = filter_var($billId, FILTER_VALIDATE_INT);
    $paidAmount = filter_var($paidAmount, FILTER_VALIDATE_FLOAT);

    if ($billId === false || $paidAmount === false) {
        return false; // Invalid input, return false
    }

    $paidDate = date('Y-m-d H:i:s');

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Prepare the update query
        $stmt = $pdo->prepare("UPDATE history SET bill_paid_date = :paidDate, bill_paid_amount = :paidAmount WHERE b_id = :billId");

        // Bind the parameters
        $stmt->bindParam(':paidAmount', $paidAmount, PDO::PARAM_STR);
        $stmt->bindParam(':paidDate', $paidDate, PDO::PARAM_STR);
        $stmt->bindParam(':billId', $billId, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Commit the transaction
        $pdo->commit();

        return true; // Data updated successfully
    } catch (PDOException $e) {
        // Roll back the transaction
        $pdo->rollBack();
        error_log("Error updating bill data: " . $e->getMessage());
        // Handle database error
        die("Error updating bill data: " . $e->getMessage());
    }
}

// Add any other functions you have in function.php

// Save data to the database if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'saveBillData') {
    $data = array(
        'billId' => $_POST['billId'],
        'paidAmount' => $_POST['paidAmount']
    );

    $result = saveBillData($data);

    if ($result) {
        echo 'Data saved successfully.';
    } else {
        echo 'Failed to save data.';
    }

    exit;
}
function getBillFromDatabase($billId)
{
    global $pdo; // Access the database connection object
    // Perform necessary database queries to fetch the bill information
    // Replace the following example code with your actual implementation

    // Assuming you have a database connection established, you can use a query like this
    $query = "SELECT * FROM history WHERE b_id = :billId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':billId', $billId);
    $stmt->execute();

    // Fetch the bill data from the result set
    $bill = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the bill data
    return $bill;
}
?>
