<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $admin = $result->fetch_assoc();

        // ✅ CHECK HASHED PASSWORD (secure way)
        if (password_verify($password, $admin['password_hash'])) {

            $_SESSION['admin'] = $admin['username'];
            $_SESSION['role'] = $admin['role'];

            header("Location: admin_dashboard.php");
            exit();

        }
        // ⚠️ TEMPORARY: support plain text passwords (if DB not hashed)
        elseif ($password === $admin['password_hash']) {

            $_SESSION['admin'] = $admin['username'];
            $_SESSION['role'] = $admin['role'];

            header("Location: admin_dashboard.php");
            exit();

        } else {
            echo "Wrong password!";
        }

    } else {
        echo "Admin not found!";
    }
}
?>