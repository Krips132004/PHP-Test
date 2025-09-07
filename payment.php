<?php
session_start();

// Redirect if customer not filled
if (empty($_SESSION['customer'])) {
    header('Location: customer.php');
    exit;
}

$cardType = $_SESSION['payment']['card_type'] ?? '';
$cardNumber = $_SESSION['payment']['card_number'] ?? '';
$expiry = $_SESSION['payment']['card_exp_date'] ?? '';
$cvv = $_SESSION['payment']['cvv'] ?? '';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardType = $_POST['card_type'] ?? '';
    $cardNumber = preg_replace('/\D+/', '', $_POST['card_number'] ?? '');
    $expiry = trim($_POST['card_exp_date'] ?? '');
    $cvv = preg_replace('/\D+/', '', $_POST['cvv'] ?? '');

    if (!in_array($cardType, ['1','2','3'])) $errors[] = 'Please select a card type';
    if (strlen($cardNumber) < 12) $errors[] = 'Card number looks too short';
    if ($expiry === '') $errors[] = 'Expiration date is required';
    if (strlen($cvv) < 3) $errors[] = 'Invalid CVV';

    if (empty($errors)) {
        $_SESSION['payment'] = [
            'card_type' => $cardType,
            'card_number' => $cardNumber,
            'card_exp_date' => $expiry,
            'cvv' => $cvv
        ];
        header('Location: review.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Checkout - Payment</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="container-card mx-auto col-md-6">
    <h3>Payment Details</h3>
    <div class="small-muted mb-3">Step 2 of 3</div>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger"><ul class="mb-0"><?php foreach($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label">Card Type</label>
        <select name="card_type" class="form-select">
          <option value="">-- Select Card --</option>
          <option value="1" <?= $cardType==='1' ? 'selected':'' ?>>Visa</option>
          <option value="2" <?= $cardType==='2' ? 'selected':'' ?>>MasterCard</option>
          <option value="3" <?= $cardType==='3' ? 'selected':'' ?>>AmEx</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Card Number</label>
        <input name="card_number" class="form-control" value="<?=htmlspecialchars($cardNumber)?>">
      </div>

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Expiration Date (MM/YY)</label>
          <input name="card_exp_date" class="form-control" placeholder="MM/YY" value="<?=htmlspecialchars($expiry)?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">CVV</label>
          <input name="cvv" class="form-control" maxlength="4" value="<?=htmlspecialchars($cvv)?>">
        </div>
      </div>

      <div class="d-flex justify-content-between mt-3">
        <a class="btn btn-outline-secondary" href="customer.php">Back</a>
        <button class="btn btn-primary" type="submit">Review Order</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
