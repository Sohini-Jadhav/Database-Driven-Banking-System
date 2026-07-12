<?php
$conn = new mysqli("localhost", "root", "", "mybank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* COUNTS */
$total_customers = $conn->query("SELECT COUNT(*) as t FROM customers")->fetch_assoc()['t'];
$total_accounts = $conn->query("SELECT COUNT(*) as t FROM accounts")->fetch_assoc()['t'];
$total_loans = $conn->query("SELECT COUNT(*) as t FROM loans")->fetch_assoc()['t'];

/* RECENT ACCOUNTS */
$accounts = $conn->query("
    SELECT a.account_number, c.full_name, a.balance
    FROM accounts a
    JOIN customers c ON a.customer_id = c.customer_id
    ORDER BY a.account_id DESC
    LIMIT 5
");

/* RECENT LOANS */
$loans = $conn->query("
    SELECT l.loan_type, l.principal_amount, l.status, c.full_name
    FROM loans l
    JOIN customers c ON l.customer_id = c.customer_id
    ORDER BY l.loan_id DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>
body {
    margin:0;
    font-family:'Segoe UI', Arial;
    background:#f4f6f9;
    overflow-y: auto;

}

.container { display:flex; }

/* SIDEBAR */
.sidebar {
    width:240px;
    background:#0d1b2a;
    color:white;
    min-height: 100vh;
    padding:20px;
}

.sidebar h2 { margin-bottom:20px; }

.sidebar a {
    display:block;
    color:#ccc;
    padding:10px;
    text-decoration:none;
    border-radius:6px;
    margin-bottom:5px;
    transition:0.3s;
}

.sidebar a:hover, .sidebar .active {
    background:#1b263b;
    color:white;
}

/* MAIN */
.main {
    flex:1;
    padding:30px;
}

/* HEADER */
.header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.header h2 { margin:0; }

.header .user {
    color:black;
    font-size:22px;
    
}

/* CARDS */
.cards {
    display:flex;
    gap:20px;
    margin-bottom:25px;
}

.card {
    flex:1;
    padding:20px;
    border-radius:12px;
    color:white;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    transition:0.3s;
    position:relative;
    overflow:hidden;
}

.card:hover {
    transform:translateY(-5px);
}

/* ICON */
.card .icon {
    position:absolute;
    right:15px;
    top:15px;
    font-size:40px;
    opacity:0.2;
}

/* TEXT */
.card h3 {
    margin:0;
    font-size:15px;
}

.card p {
    font-size:30px;
    margin:10px 0 0;
}

/* COLORS */
.customers { background:#3498db; }
.accounts { background:#2ecc71; }
.loans { background:#e67e22; }

/* SECTIONS */
.section {
    background:white;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
}

/* TABLE */
table {
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

th, td {
    padding:12px;
    border-bottom:1px solid #eee;
}

th { background:#f8f9fa; }

tr:hover { background:#f9f9f9; }

/* STATUS */
.status {
    padding:5px 10px;
    border-radius:5px;
    font-size:12px;
    color:white;
}

.approved { background:#2ecc71; }
.pending { background:#f39c12; }
.rejected { background:#e74c3c; }

</style>
</head>

<body>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>🏦 Admin</h2>
    <a href="" class="active">📊 Dashboard</a>
    <a href="customers.php">👤 Customers</a>
    <a href="accounts.php">💳 Accounts</a>
    <a href="branches.php">🏢 Branches</a>
    <a href="loans.php">📄 Loans</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<!-- HEADER -->
<div class="header">
    <h2>Dashboard</h2>
    <div class="user">👋 Welcome, Admin</div>
</div>

<!-- CARDS -->
<div class="cards">

    <div class="card customers">
        <div class="icon">👤</div>
        <h3>Total Customers</h3>
        <p><?php echo $total_customers; ?></p>
    </div>

    <div class="card accounts">
        <div class="icon">💳</div>
        <h3>Total Accounts</h3>
        <p><?php echo $total_accounts; ?></p>
    </div>

    <div class="card loans">
        <div class="icon">📄</div>
        <h3>Total Loans</h3>
        <p><?php echo $total_loans; ?></p>
    </div>

</div>

<!-- RECENT ACCOUNTS -->
<div class="section">
<h3>Recent Accounts</h3>
<table>
<tr>
    <th>Account No</th>
    <th>Name</th>
    <th>Balance</th>
</tr>

<?php while($row = $accounts->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['account_number']; ?></td>
    <td><?php echo $row['full_name']; ?></td>
    <td>₹<?php echo number_format($row['balance'],2); ?></td>
</tr>
<?php endwhile; ?>

</table>
</div>

<!-- RECENT LOANS -->
<div class="section">
<h3>Recent Loans</h3>
<table>
<tr>
    <th>Name</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Status</th>
</tr>

<?php while($row = $loans->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['full_name']; ?></td>
    <td><?php echo $row['loan_type']; ?></td>
    <td>₹<?php echo number_format($row['principal_amount'],2); ?></td>
    <td>
        <span class="status 
            <?php 
                if($row['status']=='APPROVED') echo 'approved';
                elseif($row['status']=='REJECTED') echo 'rejected';
                else echo 'pending';
            ?>">
            <?php echo $row['status']; ?>
        </span>
    </td>
</tr>
<?php endwhile; ?>

</table>
</div>

</div>
</div>

</body>
</html>