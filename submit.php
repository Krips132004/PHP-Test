<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: customer.php');
    exit;
}

if (empty($_SESSION['customer']) || empty($_SESSION['payment'])) {
    header('Location: customer.php');
    exit;
}

require_once __DIR__ . '/../db.php';

$customer = $_SESSION['customer'];
$payment = $_SESSION['payment'];

try {
    // Insert customer
    $stmt = $pdo->prepare("INSERT INTO customer_details (first_name,last_name,address,city,state,phone,email) VALUES (:first,:last,:addr,:city,:state,:phone,:email)");
    $stmt->execute([
        ':first' => $customer['first_name'],
        ':last'  => $customer['last_name'],
        ':addr'  => $customer['address'],
        ':city'  => $customer['city'],
        ':state' => $customer['state'],
        ':phone' => (int)$customer['phone'],
        ':email' => $customer['email'],
    ]);
    $customerId = $pdo->lastInsertId();

    // Insert payment (do not store CVV per PCI best practices — we will not store cvv)
    $stmt = $pdo->prepare("INSERT INTO payment_details (card_type, card_number, card_exp_date) VALUES (:type, :number, :exp)");
    $stmt->execute([
        ':type' => (int)$payment['card_type'],
        ':number' => $payment['card_number'],
        ':exp' => $payment['card_exp_date'],
    ]);
    $paymentId = $pdo->lastInsertId();

    // Clear session (or keep minimal)
    unset($_SESSION['payment']);
    unset($_SESSION['customer']);

    // Redirect to success with ids
    header("Location: success.php?c={$customerId}&p={$paymentId}");
    exit;
} catch (Exception $e) {
    // Simple error display
    $error = $e->getMessage();
}
?>
<!doctype html>
<html><body>
<h1>Error</h1>
<p><?=htmlspecialchars($error ?? 'Unknown error')?></p>
<p><a href="review.php">Back to review</a></p>
</body></html>
