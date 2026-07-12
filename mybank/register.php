<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // ✅ 1. Basic empty check
    if (empty($username) || empty($password) || empty($full_name) || empty($email) || empty($phone)) {
       echo "<script>
    alert('All fields are required');
    window.location.href='register.html';
</script>";
exit();
    }

    // ✅ 2. PASSWORD VALIDATION (ADD HERE)
    if (
        strlen($password) < 8 ||
        !preg_match("/[A-Z]/", $password) ||
        !preg_match("/[a-z]/", $password) ||
        !preg_match("/[0-9]/", $password) ||
        !preg_match("/[\W]/", $password)
    ) {
        echo "<script>
        alert('Password must be 8+ characters with uppercase, lowercase, number, and special character.');
        window.location.href='register.html';
    </script>";
    exit();
    }

    // check username
    $check = $conn->prepare("SELECT * FROM customer_login WHERE username=?");
    $check->bind_param("s",$username);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
    echo "<script>
    alert('Username already exists');
    window.location.href='register.html';
    </script>";
    exit();
}else {

        // ✅ 3. Hash AFTER validation
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // 1️⃣ Insert into customers table
        $stmt1 = $conn->prepare("INSERT INTO customers (full_name,email,phone) VALUES (?,?,?)");
        $stmt1->bind_param("sss", $full_name, $email, $phone);
        $stmt1->execute();

        // 2️⃣ Get customer_id
        $customer_id = $conn->insert_id;

        // 3️⃣ Insert into login table
        $stmt2 = $conn->prepare("INSERT INTO customer_login (customer_id,username,password_hash) VALUES (?,?,?)");
        $stmt2->bind_param("iss", $customer_id, $username, $password_hash);

        if($stmt2->execute()){
            header("Location: login.html");
            exit();
        } else {
            echo "Error: ".$stmt2->error;
        }
    }
}
?>