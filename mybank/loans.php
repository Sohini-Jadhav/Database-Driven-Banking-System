<?php
$conn = new mysqli("localhost", "root", "", "mybank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* FILTER */
$status = $_GET['status'] ?? '';

$sql = "SELECT 
            l.loan_id,
            c.full_name,
            a.account_number,
            l.loan_type,
            l.principal_amount,
            l.interest_rate,
            l.tenure_months,
            l.status
        FROM loans l
        JOIN customers c ON l.customer_id = c.customer_id
        JOIN accounts a ON l.account_id = a.account_id";

if (!empty($status)) {
    $sql .= " WHERE l.status = '$status'";
}

$sql .= " ORDER BY l.loan_id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Loans</title>

<style>
body {
    font-family: Arial;
    background: #f4f6f9;
    margin: 0;
}

/* LAYOUT */
.container {
    display: flex;
}

/* SIDEBAR */
.sidebar {
    width: 250px;
    background: #0b1a2f;
    color: white;

    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;   /* ✅ use this instead */
}

.sidebar a {
    display: block;
    color: #ccc;
    padding: 10px;
    text-decoration: none;
    border-radius: 6px;
    margin-bottom: 5px;
}

.sidebar a:hover, .sidebar .active {
    background: #1b263b;
    color: white;
}

/* MAIN */
.main {
    flex: 1;
    padding: 20px;
     margin-left: 250px;   /* same as sidebar */
    padding: 20px;

    height: auto;         /* 🔥 IMPORTANT */
    min-height: 100vh;    /* allows full page */
}

/* CARD */
.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* IMPORTANT */
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: left; /* FIX alignment */

    vertical-align: middle;

}

th {
    background: #f1f1f1;
    font-weight: bold;
}

/* STATUS */
.status {
    padding: 5px 10px;
    border-radius: 5px;
    color: white;
    font-size: 12px;
}
.approved { background: #2ecc71; }
.pending { background: #f39c12; }
.rejected { background: #e74c3c; }

/* BUTTON */
button {
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}




/* FILTER BAR RIGHT SIDE */
.filter-bar {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-bottom: 15px;
}

/* KEEP EVERYTHING IN ONE LINE */
.filter-form {
    display: flex;
    align-items: center;
    gap: 8px; /* smaller gap for tighter look */
}

/* DROPDOWN */
.filter-form select {
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background: #fff;
}

/* FILTER BUTTON (BLUE) */
.filter-btn {
    background: #3498db;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 600;
}

.filter-btn:hover {
    background: #2980b9;
}

/* RESET BUTTON */
.reset-btn {
    background: #7f8c8d;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
}

.reset-btn:hover {
    background: #636e72;
}


.top-header {
    display: flex;
    justify-content: space-between;
    align-items: center; /* makes same height */
    margin-bottom: 15px;
}

.top-header h2 {
    margin: 0;
}


</style>
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>🏦 Admin</h2>
        <a href="admin_dashboard.php">📊 Dashboard</a>
        <a href="customers.php">👤 Customers</a>
        <a href="accounts.php">💳 Accounts</a>
        <a href="branches.php">🏢 Branches</a>
        <a href="loans.php" class="active">📄 Loans</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">

        <div class="top-header">
    
    <h2>Loans</h2>

    <form method="GET" class="filter-form">
        <select name="status">
            <option value="">All</option>
            <option value="APPROVED" <?php if($status=="APPROVED") echo "selected"; ?>>Approved</option>
            <option value="PENDING" <?php if($status=="PENDING") echo "selected"; ?>>Pending</option>
            <option value="REJECTED" <?php if($status=="REJECTED") echo "selected"; ?>>Rejected</option>
        </select>

        <button type="submit" class="filter-btn">Filter</button>
        <a href="loans.php" class="reset-btn">Reset</a>
    </form>

</div>

        <div class="card">
        <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Account</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Interest</th>
            <th>Tenure</th>
            <th>Status</th>
            <th>View</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['loan_id']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['account_number']; ?></td>
            <td><?php echo $row['loan_type']; ?></td>
            <td>₹<?php echo $row['principal_amount']; ?></td>
            <td><?php echo $row['interest_rate']; ?>%</td>
            <td><?php echo $row['tenure_months']; ?> months</td>

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

            <td>
                <button onclick="viewLoan(
                    '<?php echo $row['full_name']; ?>',
                    '<?php echo $row['account_number']; ?>',
                    '<?php echo $row['loan_type']; ?>',
                    '<?php echo $row['principal_amount']; ?>',
                    '<?php echo $row['interest_rate']; ?>',
                    '<?php echo $row['status']; ?>'
                )">View</button>
            </td>
        </tr>
        <?php endwhile; ?>

        </table>
        </div>

    </div> <!-- END MAIN -->

</div> <!-- END CONTAINER -->

<!-- MODAL -->
<div id="loanModal" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.5);
">

<div style="
    background:white;
    width:400px;
    margin:100px auto;
    padding:20px;
    border-radius:10px;
">
    <h3>Loan Details</h3>

    <p><b>Name:</b> <span id="m_name"></span></p>
    <p><b>Account:</b> <span id="m_acc"></span></p>
    <p><b>Type:</b> <span id="m_type"></span></p>
    <p><b>Amount:</b> ₹<span id="m_amt"></span></p>
    <p><b>Interest:</b> <span id="m_int"></span>%</p>
    <p><b>Status:</b> <span id="m_status"></span></p>

    <button onclick="closeModal()">Close</button>
</div>

</div>

<script>
function viewLoan(name, acc, type, amt, interest, status) {
    document.getElementById('loanModal').style.display = 'block';

    document.getElementById('m_name').innerText = name;
    document.getElementById('m_acc').innerText = acc;
    document.getElementById('m_type').innerText = type;
    document.getElementById('m_amt').innerText = amt;
    document.getElementById('m_int').innerText = interest;
    document.getElementById('m_status').innerText = status;
}

function closeModal() {
    document.getElementById('loanModal').style.display = 'none';
}
</script>

</body>
</html>