<?php
$cid = isset($_GET['c']) ? (int)$_GET['c'] : 0;
$pid = isset($_GET['p']) ? (int)$_GET['p'] : 0;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Order Submitted</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="container-card mx-auto col-md-6 text-center">
    <h3>Thank you — Order submitted</h3>
    <p class="small-muted">Customer ID: <strong><?=htmlspecialchars($cid)?></strong> &nbsp; Payment ID: <strong><?=htmlspecialchars($pid)?></strong></p>
    <p>You can view the data in the database.</p>
    <a class="btn btn-primary" href="customer.php">Start new order</a>
  </div>
</div>
</body>
</html>
