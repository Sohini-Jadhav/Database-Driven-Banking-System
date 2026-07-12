<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username  = trim($_POST['username']);
    $password  = trim($_POST['password']);
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $phone     = trim($_POST['phone']);
    $role      = trim($_POST['role']);

    // 🔐 HASH PASSWORD (works with password_verify in login)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ✅ CHECK IF USERNAME EXISTS
    $check = $conn->prepare("SELECT admin_id FROM admin WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {

        echo "<script>
            alert('Username already exists!');
            window.location.href='admin_register.html';
        </script>";
        exit();

    } else {

        $stmt = $conn->prepare("
            INSERT INTO admin 
            (username, password_hash, full_name, email, phone, role) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssss",
            $username,
            $hashed_password, // ✅ important
            $full_name,
            $email,
            $phone,
            $role
        );

        if ($stmt->execute()) {

            echo "<script>
                alert('Admin registered successfully!');
                window.location.href='admin_login.html';
            </script>";
            exit();

        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>