<?php
$conn = new mysqli("localhost", "root", "", "mybank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT 
            b.branch_code,
            b.branch_name,
            b.location,
            b.manager_name,
            COUNT(a.account_id) AS total_accounts
        FROM branches b
        LEFT JOIN accounts a 
        ON b.branch_code = a.branch_code
        GROUP BY b.branch_code";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Branches</title>

    <style>
        body { margin:0; font-family:Arial; background:#f4f6f9; }
        .container { display:flex; }

        .sidebar {
            width:240px;
            background:#0d1b2a;
            color:white;
            height:100vh;
            padding:20px;
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
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;   /* THIS fixes uneven column spacing */
}

        th, td {
    padding: 12px 16px;   /* add left-right spacing */
    border-bottom: 1px solid #ddd;
    text-align: left;     /* ensures all data aligns properly */
}
th {
    background: #f1f1f1;
    font-weight: 600;
    text-align: left;   /* important */
}
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
    <a href="customers.php">👤 Customers</a>
    <a href="accounts.php">💳 Accounts</a>
    <a href="branches.php" class="active">🏢 Branches</a>
    <a href="loans.php">📄 Loans</a>
</div>

    <!-- MAIN -->
    <div class="main">

        <div class="card">
            <h2>Branches</h2>

            <table>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Location</th>
                    <th>Manager</th>
                    <th>Total Accounts</th>
                    <th>Action</th>
                </tr>

                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $row['branch_code']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td><?php echo $row['manager_name']; ?></td>
                    <td><?php echo $row['total_accounts']; ?></td>
                    <td>
                        <a href="branch_view.php?branch_code=<?php echo $row['branch_code']; ?>" class="view-btn">
                            View
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>

            </table>
        </div>

    </div>
</div>

</body>
</html>