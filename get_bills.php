<?php
// ajax.php

require_once 'db.php';
require_once 'functions.php';

if (isset($_POST['month']) && isset($_POST['year'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Fetch bills based on the provided month and year
    $bills = getBillsByMonthAndYear($month, $year);

    // Generate HTML for the bills table rows
    $html = '';
    foreach ($bills as $bill) {
        $html .= '<tr>';
        $html .= '<td>' . sanitizeInput($bill['bill_name']) . '</td>';
        $html .= '<td>';
        $html .= '<div class="d-flex align-items-center">';
        $html .= '<button type="button" class="btn btn-success pay-btn btn-pay" data-id="' . $bill['b_id'] . '">Pay</button>'; // Moved pay button here
        $html .= '</div></td><td>';
        $html .= '<span class="mr-2">' . sanitizeInput($bill['bill_paid_amount']) . '</span>';
        $html .= '</td>';
        $html .= '<td>' . sanitizeInput($bill['bill_date']) . '</td>';
        $html .= '<td>' . sanitizeInput($bill['bill_paid_date']) . '</td>';
        $html .= '<td>' . $bill['b_id'] . '</td>';
        $html .= '<td>' . sanitizeInput($bill['bill_notes']) . '</td>';
        $html .= '<td><button class="btn btn-primary edit-btn" data-id="' . $bill['b_id'] . '">Edit</button></td>';
        $html .= '</tr>';
    }


    echo $html;
}
?>
