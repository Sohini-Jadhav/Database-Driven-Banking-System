<?php
$conn = new mysqli("localhost", "root", "", "mybank");

if ($conn->connect_error) {
    die("Connection Failed : " . $conn->connect_error);
}

$message = "";

if (isset($_POST['create'])) {

    // Customer Information
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $dob = $_POST['dob'];

    // Login Details
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Account Details
    $account_type = $_POST['account_type'];
    $balance = $_POST['balance'];
    $branch_code = $_POST['branch_code'];
    $status = $_POST['status'];

    // Validation
    if ($password != $confirm_password) {
        $message = "Passwords do not match.";
    } else {

        // Check Username
        $checkUser = $conn->prepare("SELECT login_id FROM customer_login WHERE username=?");
        $checkUser->bind_param("s",$username);
        $checkUser->execute();
        $checkUser->store_result();

        if($checkUser->num_rows>0){

            $message="Username already exists.";

        }else{

            // Check Email
            $checkEmail=$conn->prepare("SELECT customer_id FROM customers WHERE email=?");
            $checkEmail->bind_param("s",$email);
            $checkEmail->execute();
            $checkEmail->store_result();

            if($checkEmail->num_rows>0){

                $message="Email already exists.";

            }else{

                $conn->begin_transaction();

                try{

                    // Insert Customer
                    $stmt=$conn->prepare("INSERT INTO customers(full_name,email,phone,address,dob)
                    VALUES(?,?,?,?,?)");

                    $stmt->bind_param(
                        "sssss",
                        $full_name,
                        $email,
                        $phone,
                        $address,
                        $dob
                    );

                    $stmt->execute();

                    $customer_id=$conn->insert_id;

                    // Password Hash
                    $password_hash=password_hash($password,PASSWORD_DEFAULT);

                    // Insert Login
                    $stmt2=$conn->prepare("INSERT INTO customer_login(customer_id,username,password_hash)
                    VALUES(?,?,?)");

                    $stmt2->bind_param(
                        "iss",
                        $customer_id,
                        $username,
                        $password_hash
                    );

                    $stmt2->execute();

                    // Generate Next Account Number
                    $result=$conn->query("SELECT MAX(account_number) AS acc FROM accounts");

                    $row=$result->fetch_assoc();

                    if($row['acc']=="")
                    {
                        $account_number=1000000001;
                    }
                    else
                    {
                        $account_number=$row['acc']+1;
                    }

                    // Insert Account
                    $stmt3=$conn->prepare("INSERT INTO accounts
                    (customer_id,account_number,account_type,balance,available_balance,status,branch_code)

                    VALUES(?,?,?,?,?,?,?)");

                    $stmt3->bind_param(
                        "iisdsss",
                        $customer_id,
                        $account_number,
                        $account_type,
                        $balance,
                        $balance,
                        $status,
                        $branch_code
                    );

                    $stmt3->execute();

                    $conn->commit();

                    echo "<script>
                    alert('Customer Account Created Successfully\\nAccount Number : $account_number');
                    window.location='accounts.php';
                    </script>";

                    exit();

                }
                catch(Exception $e){

                    $conn->rollback();

                    $message = "Error : " . $e->getMessage();

                }

            }

        }

    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Customer Account</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#f4f6f9;
    padding:40px;
}

.container{
    max-width:900px;
    margin:auto;
}

.card{
    background:#fff;
    border-radius:12px;
    padding:35px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

h1{
    text-align:center;
    margin-bottom:30px;
    color:#0d1b2a;
}

.section-title{
    font-size:20px;
    color:#1d4ed8;
    margin:25px 0 15px;
    border-bottom:2px solid #e5e7eb;
    padding-bottom:8px;
}

.row{
    display:flex;
    gap:20px;
    margin-bottom:18px;
}

.col{
    flex:1;
}

label{
    display:block;
    margin-bottom:6px;
    font-weight:600;
    color:#374151;
}

input,select,textarea{

    width:100%;
    padding:11px;
    border:1px solid #d1d5db;
    border-radius:8px;
    font-size:15px;
    background:#fafafa;

}

input:focus,
select:focus,
textarea:focus{

    outline:none;
    border-color:#2563eb;
    background:white;

}

textarea{
    resize:none;
}

.error{

    background:#fee2e2;
    color:#b91c1c;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;

}

button{

    width:100%;
    padding:14px;
    background:#0d1b2a;
    color:white;
    border:none;
    border-radius:8px;
    font-size:17px;
    cursor:pointer;
    margin-top:20px;

}

button:hover{

    background:#1d4ed8;

}

.back{

display:inline-block;
margin-bottom:20px;
text-decoration:none;
background:#0d1b2a;
color:white;
padding:8px 14px;
border-radius:6px;

}

</style>

</head>

<body>

<div class="container">

<a href="accounts.php" class="back">
← Back
</a>

<div class="card">

<h1>Create Customer Account</h1>

<?php
if($message!=""){
    echo "<div class='error'>$message</div>";
}
?>

<form method="POST" id="accountForm">

<div class="section-title">
Customer Information
</div>

<div class="row">

<div class="col">
<label>Full Name</label>
<input
type="text"
name="full_name"
required>
</div>

<div class="col">
<label>Email</label>
<input
type="email"
name="email"
required>
</div>

</div>

<div class="row">

<div class="col">
<label>Phone</label>
<input
type="text"
name="phone"
maxlength="10"
required>
</div>

<div class="col">
<label>Date of Birth</label>
<input
type="date"
name="dob">
</div>

</div>

<label>Address</label>

<textarea
name="address"
rows="3"></textarea>

<div class="section-title">
Login Details
</div>

<div class="row">

<div class="col">
<label>Username</label>

<input
type="text"
name="username"
required>

</div>

<div class="col">

<label>Password</label>

<input
type="password"
name="password"
id="password"
required>

</div>

</div>

<div class="row">

<div class="col">

<label>Confirm Password</label>

<input
type="password"
name="confirm_password"
id="confirm_password"
required>

</div>

<div class="col"></div>

</div>

<div class="section-title">
Account Details
</div>

<div class="row">

<div class="col">

<label>Account Type</label>

<select name="account_type">

<option>Savings</option>

<option>Current</option>

</select>

</div>

<div class="col">

<label>Opening Balance</label>

<input
type="number"
step="0.01"
name="balance"
value="0"
required>

</div>

</div>

<div class="row">

<div class="col">

<label>Branch</label>

<select name="branch_code">

<option value="BR001">BR001</option>
<option value="BR002">BR002</option>
<option value="BR003">BR003</option>
<option value="BR004">BR004</option>
<option value="BR005">BR005</option>

</select>

</div>

<div class="col">

<label>Status</label>

<select name="status">

<option>Active</option>
<option>Blocked</option>
<option>Inactive</option>

</select>

</div>

</div>

<button type="submit" name="create">
    Create Customer Account
</button>

</form>

</div>
</div>

<script>

const form=document.getElementById("accountForm");

form.addEventListener("submit",function(e){

    const phone=document.querySelector("[name='phone']").value.trim();

    const password=document.getElementById("password").value;

    const confirm=document.getElementById("confirm_password").value;

    if(phone.length!=10 || isNaN(phone))
    {
        alert("Phone number must contain exactly 10 digits.");
        e.preventDefault();
        return;
    }

    if(password.length<8)
    {
        alert("Password must be at least 8 characters.");
        e.preventDefault();
        return;
    }

    if(password!==confirm)
    {
        alert("Passwords do not match.");
        e.preventDefault();
        return;
    }

});

</script>

</body>
</html>