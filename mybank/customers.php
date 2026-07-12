<?php
$conn = new mysqli("localhost", "root", "", "mybank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT 
            c.customer_id,
            c.full_name,
            c.email,
            c.phone,
            COUNT(a.account_id) AS total_accounts,
            IFNULL(SUM(a.balance),0) AS total_balance
        FROM customers c
        LEFT JOIN accounts a ON c.customer_id = a.customer_id
        GROUP BY c.customer_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Customers</title>

<style>
body { margin:0; font-family:Arial; background:#f4f6f9; }
.container { display:flex; }

.sidebar {
    width:240px;
    background:#0d1b2a;
    color:white;
    height:100vh;
    padding:20px;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0
}

.sidebar a {
    display:block;
    color:#ccc;
    padding:10px;
    text-decoration:none;
    border-radius:6px;
}

.sidebar a.active, .sidebar a:hover {
    background:#1b263b;
    color:white;
}

.main { flex:1; padding:20px; }

.card {
    background:#fff;
    padding:20px;
    border-radius:10px;
}

table {
    width:100%;
    border-collapse:collapse;
}

th, td {
    padding:12px;
    border-bottom:1px solid #ddd;
}

th { background:#f1f1f1; }

.view-btn {
    background:#3498db;
    color:white;
    padding:6px 10px;
    text-decoration:none;
    border-radius:5px;
}
</style>
</head>

<body>

<div class="container">

<div class="sidebar">
    <h2>🏦 Admin</h2>
    <a href="admin_dashboard.php" >📊 Dashboard</a>
    <a href="customers.php" class="active">👤 Customers</a>
    <a href="accounts.php">💳 Accounts</a>
    <a href="branches.php">🏢 Branches</a>
    <a href="loans.php">📄 Loans</a>
</div>

<div class="main">

<div class="card">
<h2>Customers</h2>

<table>
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Accounts</th>
    <th>Total Balance</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['full_name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['phone']; ?></td>
    <td><?php echo $row['total_accounts']; ?></td>
    <td>₹<?php echo $row['total_balance']; ?></td>
    <td>
        <a href="customers_view.php?id=<?php echo $row['customer_id']; ?>" class="view-btn">View</a>
    </td>
</tr>
<?php endwhile; ?>

</table>
</div>

</div>
</div>

</body>
</html>