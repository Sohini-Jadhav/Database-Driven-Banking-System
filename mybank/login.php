<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);




session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ✅ Remove spaces issue
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare query to get the customer data
    $stmt = $conn->prepare("SELECT * FROM customer_login WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        $stored_password = $customer['password_hash'];

        // ✅ 1. Primary Check: Verify using modern secure hashing
        $is_valid = password_verify($password, $stored_password);

        // ✅ 2. Fallback Check: If it fails, check if the DB still has an old plain-text password
        if (!$is_valid && $password === $stored_password) {
            $is_valid = true;
        }

        if ($is_valid) {
            $_SESSION['customer_id'] = $customer['customer_id'];
            $_SESSION['customer'] = $username;
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: login.html?error=wrongpass");
            exit();
        }

    } else {
        header("Location: login.html?error=nouser");
        exit();
    }
}
?>