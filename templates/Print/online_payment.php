<?php


/**
 * Do not forget to set these to your Account credentials.
 * It would be better to store these as an admin setting.
 **/
define('MERCHANT_ID', 'MCP');
define('MERCHANT_PASSWORD', 'j5E1gBHp7njK9t4');

define('ENV_TEST', 0);
define('ENV_LIVE', 1);

$environment = ENV_TEST;

?>

  <?php

  $errors = array();
  $is_link = false;



  $cleanedString = str_replace("REQ-", "", $data['code']);

  $txnid = '0'.$cleanedString;

  $txnid = $data['code'];

  $description = $data['purpose'];
  $email = $data['Student']['email'];
  $amount = '500.00';
  
  $parameters = array(
      'merchantid' => MERCHANT_ID,
      'txnid' => $txnid,
      'amount' => $amount,
      'ccy' => 'PHP',
      'description' => $description,
      'email' => $email,
  );


  $fields = array(
      'txnid' => array(
          'label' => 'Transaction ID',
          'type' => 'text',
          'attributes' => array(),
          'filter' => FILTER_SANITIZE_STRING,
          'filter_flags' => array(FILTER_FLAG_STRIP_LOW),
      ),
      'amount' => array(
          'label' => 'Amount',
          'type' => 'number',
          'attributes' => array('step="0.01"'),
          'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
          'filter_flags' => array(FILTER_FLAG_ALLOW_THOUSAND, FILTER_FLAG_ALLOW_FRACTION),
      ),
      'description' => array(
          'label' => 'Description',
          'type' => 'text',
          'attributes' => array(),
          'filter' => FILTER_SANITIZE_STRING,
          'filter_flags' => array(FILTER_FLAG_STRIP_LOW),
      ),
      'email' => array(
          'label' => 'Email',
          'type' => 'email',
          'attributes' => array(),
          'filter' => FILTER_SANITIZE_EMAIL,
          'filter_flags' => array(),
      ),
  );


  foreach ($fields as $key => $value) {
    // Sanitize user input. However:
    // NOTE: this is a sample, user's SHOULD NOT be inputting these values.
    if (isset($_POST[$key])) {
        $parameters[$key] = filter_input(INPUT_POST, $key, $value['filter'],
          array_reduce($value['filter_flags'], function ($a, $b) { return $a | $b; }, 0));
    }
  }


  $parameters['amount'] = number_format($parameters['amount'], 2, '.', '');
  // Unset later from parameter after digest.
  $parameters['key'] = MERCHANT_PASSWORD;
  $digest_string = implode(':', $parameters);
  unset($parameters['key']);
  // NOTE: To check for invalid digest errors,
  // uncomment this to see the digest string generated for computation.
  // var_dump($digest_string); $is_link = true;


  $digest = sha1($digest_string);



  if (isset($_POST['submit'])) {
    // Check for set values.
    foreach ($fields as $key => $value) {
      // Sanitize user input. However:
      // NOTE: this is a sample, user's SHOULD NOT be inputting these values.
      if (isset($_POST[$key])) {
          $parameters[$key] = filter_input(INPUT_POST, $key, $value['filter'],
            array_reduce($value['filter_flags'], function ($a, $b) { return $a | $b; }, 0));
      }
    }

    // Validate values.
    // Example, amount validation.
    // Do not rely on browser validation as the client can manually send
    // invalid values, or be using old browsers.
    if (!is_numeric($parameters['amount'])) {
      $errors[] = 'Amount should be a number.';
    }
    else if ($parameters['amount'] <= 0) {
      $errors[] = 'Amount should be greater than 0.';
    }

    if (empty($errors)) {
      // Transform amount to correct format. (2 decimal places,
      // decimal separated by period, no thousands separator)
      $parameters['amount'] = number_format($parameters['amount'], 2, '.', '');
      // Unset later from parameter after digest.
      $parameters['key'] = MERCHANT_PASSWORD;
      $digest_string = implode(':', $parameters);
      unset($parameters['key']);
      // NOTE: To check for invalid digest errors,
      // uncomment this to see the digest string generated for computation.
      // var_dump($digest_string); $is_link = true;
      $parameters['digest'] = sha1($digest_string);

      $digest = sha1($digest_string);

      // $url = 'https://gw.dragonpay.ph/Pay.aspx?';
      // if ($environment == ENV_TEST) {
      //   $url = 'http://test.dragonpay.ph/Pay.aspx?';
      // }

      // $url .= http_build_query($parameters, '', '&');

      // if ($is_link) {
      //   echo '<br><a href="' . $url . '">' . $url . '</a>';
      // }
      // else {
      //   header("Location: $url");
      // }
    }
  }
  ?>


<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      width: 900px;
      background-color: #f0f0f0;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.9);
    }

    .form {
      text-align: center;
    }

    label {width: 130px; float: left;}
    /* Modify the input fields to be bigger and have rounded corners */
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"] {
      width: 300px; /* Increase the width to make the input fields bigger */
      padding: 10px; /* Add some padding inside the input fields */
      border-radius: 5px; /* Add rounded corners */
      border: 1px solid #ccc; /* Add a border to the input fields */
    }

    /* Center align the "Pay Now" button and make it blue */
    input[type="submit"] {
      display: block;
      margin: 100px auto 10px; /* Increase margin-bottom to push the button further down */
      background-color: #007bff; /* Change the background color to blue */
      color: #fff; /* Set the text color to white */
      border: none; /* Remove the default border */
      border-radius: 5px; /* Add some border radius for rounded corners */
      padding: 10px 20px; /* Add padding to make the button more prominent */
      font-size: 16px; /* Set the font size */
      cursor: pointer; /* Show a pointer cursor on hover */
    }

    /* Add spacing between fields */
    .input {
      margin-bottom: 20px;
      text-align: left;
    }

    /* Style the above-form-text as a header */
    .above-form-text {
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 80px;
      font-family: Arial, sans-serif; /* Set the font-family to Arial */
    }

    /* Add spacing between the header and fields */
    .form-container .form {
      margin-top: 30px;
    }

    /* Add spacing between individual input fields */
    .input input {
      margin-top: 5px;
    }
  </style>
</head>

<body>
  <div class="form-container">
    <div style="display: flex;">
      <div style="flex: 1;">
        <h1 class="above-form-text">Welcome to ZSCMST payment portal. Please proceed with your payment.</h1>

        <?php if (!empty($errors)): ?>
          <div class="errors">
            <div class="error">
              <?php echo implode('</div><div class="error">', $errors); ?>
            </div>
          </div>
        <?php endif; ?>

        <div class="form">
          <form method="post">
            <?php foreach ($fields as $key => $value): ?>
              <div class="input">
                <span class="label"><label for="<?php echo $key; ?>">
                <?php echo $value['label']; ?>:</label></span>
                <input type="<?php echo $value['type']; ?>"
                  <?php echo implode(' ', $value['attributes']); ?>
                  name="<?php echo $key; ?>" value="<?php echo $parameters[$key]; ?>">
              </div>
            <?php endforeach; ?>
            <!-- <input type="submit" name="submit" value="Pay Now"> -->
          
            <button id="myButton" style="width: 200px;">
              <a style="pointer-events: none; color: inherit; text-decoration: none; cursor: default;" href="https://test.dragonpay.ph/Pay.aspx?merchantid=MCP&txnid=<?php echo $parameters['txnid']; ?>&amount=<?php echo $amount; ?>&ccy=PHP&description=<?php echo $description; ?>&email=<?php echo $email; ?>&digest=<?php echo $digest; ?>">
                Pay now
              </a>
            </button>
          </form>
        </div>
      </div>

      <!-- Add the image to the right -->
      <div style="flex: 1; display: flex; justify-content: center; align-items: center;">
        <img src="<?php echo $base ?>/assets/img/payment.png" alt="Image" style="max-width: 100%; max-height: 100%;">
      </div>
    </div>
  </div>
</body>
</html>

<script>
  // JavaScript click event handler
  document.getElementById("myButton").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default button click behavior
    var paymentLink = this.querySelector("a").getAttribute("href");
    window.location.href = paymentLink; // Redirect to the payment link
  });
</script>

