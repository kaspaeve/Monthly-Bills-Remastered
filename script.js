// Sanitize user input to prevent SQL injection attacks
function sanitizeInput(input) {
  if (typeof input === 'string' || input instanceof String) {
    return input.replace(/</g, '&lt;').replace(/>/g, '&gt;');
  } else {
    return '';
  }
}

// Validate user input to prevent SQL injection attacks
function validateInput(input) {
  return input.match(/^[a-zA-Z0-9\s]+$/);
}

function viewBills() {
  var month = sanitizeInput($('#month').val());
  var year = sanitizeInput($('#year').val());

  if (month !== '' && year !== '') {
    $.ajax({
      type: 'POST',
      url: 'ajax.php',
      data: {
        action: 'fetchBills',
        month: month,
        year: year
      },
      success: function (response) {
        // Clear the table body
        $('#bills-table tbody').empty();

        // Check if response is not empty
        if (response.length > 0) {
          // Populate the table with the retrieved data
          for (var i = 0; i < response.length; i++) {
            var row = '<tr>' +
              '<td>' + sanitizeInput(response[i].bill_name) + '</td>' +
              '<td>' +
              '<div class="d-flex align-items-center">' +
              '<span class="mr-2">' + sanitizeInput(response[i].bill_paid_amount) + '</span>' +
              '<div class="input-group-append">' +
              '<button type="button" class="btn btn-success pay-btn btn-pay" data-id="' + response[i].b_id + '">Pay</button>' +
              '</div>' +
              '</div>' +
              '</td>' +
              '<td>' + sanitizeInput(response[i].bill_date) + '</td>' +
              '<td>' + sanitizeInput(response[i].bill_paid_date) + '</td>' +
              '<td>' + response[i].b_id + '</td>' +
              '<td>' + sanitizeInput(response[i].bill_notes) + '</td>' +
              '<td><button class="btn btn-primary edit-btn" data-id="' + response[i].b_id + '">Edit</button></td>' +
              '</tr>';

            // Append the row to the table
            $('#bills-table tbody').append(row);
          }

          // Attach click event to edit buttons
          $('.edit-btn').click(editBill);

          // Attach click event to pay buttons
          $('.pay-btn').click(function () {
            var billId = $(this).data('id');
            var billName = $(this).closest('tr').find('td:first-child').text().trim();
            $('#bill-name').val(billName); // Set the bill name in the input field
            $('#bill-amount').val(''); // Clear the amount input
            $('#pay-btn').data('id', billId); // Set the bill ID as a data attribute of the Pay button
            $('#paymentModal').modal('show'); // Show the payment modal
          });
        } else {
          // If the response is empty, display a message or handle accordingly
          $('#bills-table tbody').append('<tr><td colspan="7">No bills found.</td></tr>');
        }
      },
      error: function () {
        showErrorToast('Error fetching bill data.');
      }
    });
  }
}



function payBill(billId, amount) {
  var paidAmount = sanitizeInput(amount);

  if (billId !== '' && paidAmount !== '') {
    var currentTimestamp = new Date().toISOString(); // Get the current timestamp

    $.ajax({
      type: 'POST',
      url: 'ajax.php',
      data: {
        action: 'payBill',
        billId: billId,
        paidAmount: paidAmount,
        paidDate: currentTimestamp // Include the current timestamp in the data
      },
      success: function (response) {
        if (response === 'success') {
          showSuccessToast('Payment successfully updated!');

          // Refresh the bill table
          viewBills();
        } else {
          showErrorToast('Error updating payment!');
        }
      },
      error: function () {
        showErrorToast('Error updating payment!');
      }
    });

    // Retrieve the bill details and populate the payment modal
    $.ajax({
      type: 'POST',
      url: 'get_bill.php',
      data: {
        billId: billId
      },
      success: function (response) {
        var data = JSON.parse(response);
        $('#bill-name').val(data.bill_name);
        $('#bill-amount').val(data.bill_paid_amount); // Update the paid amount field in the payment modal
        $('#bill-notes').val(data.bill_notes); // Update the notes field in the payment modal with the retrieved notes
        $('#paymentModal').modal('show'); // Open the payment modal
      },
      error: function () {
        showErrorToast('Error retrieving bill data.');
      }
    });

    // Clear the input fields
    $('#bill-amount').val('');
  }
}

// Code for editing bill data and updating in the database
function editBill() {
  var b_id = $(this).data('id');

  // Get the bill data to populate the edit form
  $.ajax({
    url: 'functions.php',
    type: 'POST',
    data: {
      action: 'getBill',
      billId: b_id
    },
    success: function (response) {
      // Populate the edit form with the retrieved data
      var data = JSON.parse(response);
      $('#edit-bill-id').val(data.b_id);
      $('#edit-bill-name').val(data.bill_name);
      $('#edit-bill-amount').val(data.bill_paid_amount);
      $('#edit-bill-date').val(data.bill_paid_date);
      $('#edit-bill-notes').val(data.bill_notes);

      // Open the edit modal
      $('#edit-modal').modal('show');
    },
    error: function () {
      showErrorToast('Error retrieving bill data.');
    }
  });
}

// Code for displaying success and error toasts
function showSuccessToast(message) {
  $.toast({
    text: message,
    icon: 'success',
    position: 'top-right',
    hideAfter: 3000,
    stack: false
  });
}

function showErrorToast(message) {
  $.toast({
    text: message,
    icon: 'error',
    position: 'top-right',
    hideAfter: 3000,
    stack: false
  });
}

$(document).ready(function () {
  // Trigger the viewBills function when the View button is clicked
  $('#view-btn').click(function () {
    viewBills();
  });

  // Listener for the Pay button inside the payment modal
  $('#pay-btn').click(function () {
    var billId = $(this).data('id');
    var amount = sanitizeInput($('#bill-amount').val());

    // Perform validation on the amount
    if (amount !== '') {
      // Process the payment
      payBill(billId, amount);
      $('#paymentModal').modal('hide'); // Hide the payment modal
    } else {
      showErrorToast('Please enter a valid amount.');
    }
  });

  // Trigger the viewBills function on page load
  viewBills();

  // Attach click event to edit buttons
  $('.edit-btn').click(editBill);
});
