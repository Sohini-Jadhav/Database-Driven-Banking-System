<?php
$conn = new mysqli("localhost", "root", "", "mybank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_GET['id']);

// Customer info
$customer = $conn->query("SELECT * FROM customers WHERE customer_id=$id")->fetch_assoc();

// Accounts + Branch
$accounts = $conn->query("
    SELECT 
        a.account_number,
        a.account_type,
        a.balance,
        a.status,
        b.branch_name
    FROM accounts a
    LEFT JOIN branches b ON a.branch_code = b.branch_code
    WHERE a.customer_id = $id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Customer Details</title>

<style>
body { font-family:Arial; background:#f4f6f9; padding:20px; }

.card {
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
    position:relative;
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
</style>
</head>

<body>

<div class="card">

<!-- BACK BUTTON -->
<a href="customers.php" style="
    position:absolute;
    top:20px;
    right:20px;
    padding:6px 12px;
    background:#0d1b2a;
    color:white;
    text-decoration:none;
    border-radius:6px;
">
← Back
</a>

<h2><?php echo $customer['full_name']; ?></h2>
<p><b>Email:</b> <?php echo $customer['email']; ?></p>
<p><b>Phone:</b> <?php echo $customer['phone']; ?></p>
<p><b>Address:</b> <?php echo $customer['address']; ?></p>
<p><b>DOB:</b> <?php echo $customer['dob']; ?></p>

</div>

<div class="card">
<h3>Accounts of this Customer</h3>

<table>
<tr>
    <th>Account No</th>
    <th>Type</th>
    <th>Balance</th>
    <th>Status</th>
    <th>Branch</th>
</tr>

<?php while($row = $accounts->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['account_number']; ?></td>
    <td><?php echo $row['account_type']; ?></td>
    <td>₹<?php echo $row['balance']; ?></td>
    <td><?php echo $row['status']; ?></td>
    <td><?php echo $row['branch_name']; ?></td>
</tr>
<?php endwhile; ?>

</table>
</div>

</body>
</html>