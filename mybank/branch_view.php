<?php
$conn = new mysqli("localhost", "root", "", "mybank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$branch_code = $_GET['branch_code'];

// Branch info
$branch = $conn->query("SELECT * FROM branches WHERE branch_code='$branch_code'")->fetch_assoc();

// Accounts in this branch
$accounts = $conn->query("
    SELECT a.account_number, a.account_type, a.balance, c.full_name
    FROM accounts a
    JOIN customers c ON a.customer_id = c.customer_id
    WHERE a.branch_code = '$branch_code'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Branch Details</title>

    <style>
        body { font-family:Arial; background:#f4f6f9; padding:20px; }

        .card {
            background:white;
            padding:20px;
            border-radius:10px;
            margin-bottom:20px;
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
    <h2><?php echo $branch['branch_name']; ?></h2>
    <p><b>Code:</b> <?php echo $branch['branch_code']; ?></p>
    <p><b>Location:</b> <?php echo $branch['location']; ?></p>
    <p><b>Manager:</b> <?php echo $branch['manager_name']; ?></p>
    <p><b>Phone:</b> <?php echo $branch['phone']; ?></p>
</div>

<div class="card">


<a href="branches.php" style="
    position:absolute;
    top:20px;
    right:20px;
    padding:6px 12px;
    background:#0d1b2a;
    color:white;
    text-decoration:none;
    border-radius:6px;
    font-size:14px;
">
    ← Back
</a>

    <h3>Accounts in this Branch</h3>

    <table>
        <tr>
            <th>Account No</th>
            <th>Customer</th>
            <th>Type</th>
            <th>Balance</th>
        </tr>

        <?php while($row = $accounts->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['account_number']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['account_type']; ?></td>
            <td><?php echo $row['balance']; ?></td>
        </tr>
        <?php endwhile; ?>

    </table>
</div>

</body>
</html>