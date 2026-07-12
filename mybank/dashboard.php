<?php
session_start();
include "db.php";

$username = $_SESSION['customer'] ?? '';

$sql = "SELECT c.full_name,a.balance,a.account_number,a.account_type
FROM customers c
JOIN customer_login l ON c.customer_id = l.customer_id
LEFT JOIN accounts a ON a.customer_id = c.customer_id
WHERE l.username='$username'";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    $data = [];
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Bank Dashboard</title>

<style>
body{
    margin:0;
    font-family: 'Inter', sans-serif;
    display:flex;
    background:#f1f5f9;
}

.sidebar{
    width:240px;
    background:linear-gradient(180deg,#0f172a,#1e293b);
    color:white;
    height:100vh;
    padding:25px 20px;
}

.sidebar h2{
    margin-bottom:40px;
    font-weight:600;
}

.sidebar a{
    display:block;
    padding:12px 14px;
    color:#cbd5f1;
    text-decoration:none;
    border-radius:8px;
    margin-bottom:8px;
    transition:0.3s;
    font-size:14px;
}

.sidebar a:hover{
    background:#334155;
    color:white;
}

.main{
    flex:1;
    padding:30px;
}

.card{
    background:white;
    padding:22px;
    border-radius:12px;
    box-shadow:0 4px 20px rgba(0,0,0,0.05);
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:14px;
    text-align:left;
}

th{
    background:#f8fafc;
    font-size:13px;
    color:#64748b;
}

td{
    border-bottom:1px solid #f1f5f9;
}


.top-card{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logout-btn{
    background:#97144d;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
    font-weight:500;
    transition:0.3s;
}

.logout-btn:hover{
    background:#b91c1c;
}


</style>
</head>

<body>

<div class="sidebar">
<h2>MyBank</h2>
<a href="dashboard.php">📊 Dashboard</a>
<a href="transfer.php">💸 Transfer</a>
<a href="profile.php">👤 Profile</a>
<a href="apply_loan.html">📄 Apply Loan</a>
<a href="logout.php">🚪 Logout</a>
</div>

<div class="main">

<div class="card top-card">
    <h2>Welcome, <?php echo $data['full_name'] ?? 'User'; ?></h2>
    <a href="logout.php"><button class="logout-btn">Logout</button></a>
</div>

<div class="card">
<h3>Total Balance</h3>
<h1>₹ <?php echo $data['balance'] ?? '0'; ?></h1>
</div>

<div class="card">
<h3>Account Information</h3>

<table>
<tr>
<th>Account Number</th>
<th>Account Type</th>
<th>Balance</th>
</tr>

<tr>
<td><?php echo $data['account_number'] ?? '-'; ?></td>
<td><?php echo $data['account_type'] ?? '-'; ?></td>
<td>₹ <?php echo $data['balance'] ?? '0'; ?></td>
</tr>

</table>

</div>

</div>

</body>
</html>