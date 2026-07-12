<?php
session_start();
include "db.php";

$customer_id = $_SESSION['customer_id'];

$getAcc = $conn->query("SELECT account_number FROM accounts WHERE customer_id = $customer_id");
$row = $getAcc->fetch_assoc();

$sender = $row['account_number'];
$receiver = $_POST['receiver_account'];
$amount = $_POST['amount'];

/* VALIDATION */
if ($sender == $receiver) {
    echo "<script>alert('Cannot transfer to same account'); window.history.back();</script>";
    exit;
}

if ($amount <= 0) {
    echo "<script>alert('Enter valid amount'); window.history.back();</script>";
    exit;
}

/* CHECK SENDER */
$res = $conn->query("SELECT available_balance FROM accounts WHERE account_number='$sender'");

if (!$res || $res->num_rows == 0) {
    echo "<script>alert('Sender account not found'); window.history.back();</script>";
    exit;
}

$row = $res->fetch_assoc();
$current_balance = $row['available_balance'];

/* CHECK BALANCE */
if ($amount > $current_balance) {
    echo "<script>alert('Insufficient balance'); window.history.back();</script>";
    exit;
}

/* CHECK RECEIVER */
$res2 = $conn->query("SELECT * FROM accounts WHERE account_number='$receiver'");
if (!$res2 || $res2->num_rows == 0) {
    echo "<script>alert('Receiver account not found'); window.history.back();</script>";
    exit;
}

/* TRANSFER LOGIC */
$conn->query("UPDATE accounts 
              SET balance = balance - $amount,
                  available_balance = available_balance - $amount
              WHERE account_number='$sender'");

$conn->query("UPDATE accounts 
              SET balance = balance + $amount,
                  available_balance = available_balance + $amount
              WHERE account_number='$receiver'");

/* ✅ FIX: GET customer_id (REQUIRED FOR FK) */
$getCust = $conn->query("SELECT customer_id FROM accounts WHERE account_number='$sender'");
$custRow = $getCust->fetch_assoc();
$customer_id = $custRow['customer_id'];

/* ✅ TRANSACTION SAVE */
$txn_ref = "TXN" . rand(100000,999999);

$conn->query("INSERT INTO transactions 
(customer_id, transaction_ref, from_account, to_account, amount, transaction_type, status, narration, transaction_date) 
VALUES 
($customer_id, '$txn_ref', '$sender', '$receiver', $amount, 'TRANSFER', 'SUCCESS', 'Money Transfer', NOW())");

/* SUCCESS */
echo "<script>
alert('Transfer Successful!');
window.location.href='dashboard.php';
</script>";
?>