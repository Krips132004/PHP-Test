<?php
session_start();

// Pre-fill values if present
$first = $_SESSION['customer']['first_name'] ?? '';
$last  = $_SESSION['customer']['last_name'] ?? '';
$address = $_SESSION['customer']['address'] ?? '';
$city = $_SESSION['customer']['city'] ?? '';
$state = $_SESSION['customer']['state'] ?? '';
$phone = $_SESSION['customer']['phone'] ?? '';
$email = $_SESSION['customer']['email'] ?? '';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simple sanitization/validation
    $first = trim($_POST['first_name'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = strtoupper(trim($_POST['state'] ?? ''));
    $phone = preg_replace('/\D+/', '', $_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($first === '') $errors[] = 'First name is required';
    if ($last === '') $errors[] = 'Last name is required';
    if ($address === '') $errors[] = 'Address is required';
    if ($city === '') $errors[] = 'City is required';
    if ($state === '' || strlen($state) !== 2) $errors[] = 'State must be 2-letter code';
    if ($phone === '' || strlen($phone) < 7) $errors[] = 'Phone is required';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';

    if (empty($errors)) {
        $_SESSION['customer'] = [
            'first_name'=>$first,
            'last_name'=>$last,
            'address'=>$address,
            'city'=>$city,
            'state'=>$state,
            'phone'=>$phone,
            'email'=>$email
        ];
        header('Location: payment.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Checkout - Customer</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="container-card mx-auto col-md-8">
    <h3>Checkout — Customer Details</h3>
    <div class="small-muted mb-3">Step 1 of 3</div>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" novalidate>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">First Name</label>
          <input name="first_name" class="form-control" value="<?=htmlspecialchars($first)?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Last Name</label>
          <input name="last_name" class="form-control" value="<?=htmlspecialchars($last)?>">
        </div>

        <div class="col-12">
          <label class="form-label">Address</label>
          <input name="address" class="form-control" value="<?=htmlspecialchars($address)?>">
        </div>

        <div class="col-md-6">
          <label class="form-label">City</label>
          <input name="city" class="form-control" value="<?=htmlspecialchars($city)?>">
        </div>
        <div class="col-md-2">
          <label class="form-label">State</label>
          <input name="state" class="form-control" maxlength="2" value="<?=htmlspecialchars($state)?>">
        </div>
        <div class="col-md-4">
          <label class="form-label">Phone</label>
          <input name="phone" class="form-control" value="<?=htmlspecialchars($phone)?>">
        </div>

        <div class="col-12">
          <label class="form-label">Email</label>
          <input name="email" class="form-control" value="<?=htmlspecialchars($email)?>">
        </div>

        <div class="col-12 d-flex justify-content-between mt-2">
          <div></div>
          <button class="btn btn-primary" type="submit">Continue to Payment</button>
        </div>
      </div>
    </form>
  </div>
</div>
</body>
</html>
