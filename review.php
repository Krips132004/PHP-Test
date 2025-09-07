<?php
session_start();
if (empty($_SESSION['customer']) || empty($_SESSION['payment'])) {
    header('Location: customer.php');
    exit;
}

$customer = $_SESSION['customer'];
$payment = $_SESSION['payment'];

$cardNames = ['1'=>'Visa','2'=>'MasterCard','3'=>'AmEx'];
$maskedCard = substr($payment['card_number'], -4);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Checkout - Review</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="container-card mx-auto col-md-8">
    <h3>Review Order</h3>
    <div class="small-muted mb-3">Step 3 of 3</div>

    <h5>Customer Information</h5>
    <p><strong><?=htmlspecialchars($customer['first_name'].' '.$customer['last_name'])?></strong><br>
      <?=htmlspecialchars($customer['address'])?><br>
      <?=htmlspecialchars($customer['city'].', '.$customer['state'])?><br>
      Phone: <?=htmlspecialchars($customer['phone'])?><br>
      Email: <?=htmlspecialchars($customer['email'])?></p>

    <h5>Payment</h5>
    <p>
      Card: <?=htmlspecialchars($cardNames[$payment['card_type']] ?? 'Unknown')?> <br>
      Card Number: **** **** **** <?=htmlspecialchars($maskedCard)?> <br>
      Expires: <?=htmlspecialchars($payment['card_exp_date'])?>
    </p>

    <form action="submit.php" method="post" onsubmit="return confirm('Submit and save to database?');">
      <div class="d-flex justify-content-between">
        <a class="btn btn-outline-secondary" href="payment.php">Back</a>
        <button class="btn btn-primary" type="submit">Submit Order</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
