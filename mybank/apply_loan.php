<?php
session_start();
include "db.php";

// 🔥 SHOW ERRORS (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ CHECK LOGIN
if (!isset($_SESSION['customer_id'])) {
    die("⚠️ Please login first.");
}

$customer_id = $_SESSION['customer_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 🔥 Fetch account_id
    $query = "SELECT account_id FROM accounts WHERE customer_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $customer_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        die("❌ No account found for this user");
    }

    $account_id = $row['account_id'];

    // Get form data safely
    $loan_type = $_POST['loan_type'] ?? '';
    $principal_amount = $_POST['principal_amount'] ?? 0;
    $tenure_months = $_POST['tenure_months'] ?? 0;

    // Basic validation
    if ($principal_amount <= 0 || $tenure_months <= 0) {
        die("⚠️ Invalid input values");
    }

   if ($loan_type == "Home Loan") {
    $interest_rate = 7.2;
} elseif ($loan_type == "Education Loan") {
    $interest_rate = 6.5;
} else {
    $interest_rate = 8.5; // Personal Loan
}
    $status = "PENDING";

    // Insert into DB
    $sql = "INSERT INTO loans 
            (customer_id, account_id, loan_type, principal_amount, interest_rate, tenure_months, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("SQL Error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "iisdiis",
        $customer_id,
        $account_id,
        $loan_type,
        $principal_amount,
        $interest_rate,
        $tenure_months,
        $status
    );

    if (mysqli_stmt_execute($stmt)) {

    echo "
    <!DOCTYPE html>
    <html>
    <head>
    <title>Success</title>

    <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: #f4f6f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .success-box {
        background: white;
        padding: 30px 40px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .success-icon {
        font-size: 40px;
        color: green;
    }

    .success-text {
        font-size: 20px;
        margin-top: 10px;
        color: #333;
    }
    </style>

    <!-- Redirect after 2.5 seconds -->
    <meta http-equiv='refresh' content='2.5;url=dashboard.php'>

    </head>

    <body>

    <div class='success-box'>
        <div class='success-icon'>✔</div>
        <div class='success-text'>Loan Applied Successfully!</div>
    </div>

    </body>
    </html>
    ";

} else {
        echo "❌ Insert Error: " . mysqli_error($conn);
    }
}
?>