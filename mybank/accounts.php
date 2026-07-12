<?php
$conn = new mysqli("localhost", "root", "", "mybank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* DELETE LOGIC (POST) */
if (isset($_POST['delete'])) {
    $delete_id = intval($_POST['delete_id']);

    // delete loans first
    $conn->query("DELETE FROM loans WHERE account_id = $delete_id");

    // then delete account
    if ($conn->query("DELETE FROM accounts WHERE account_id = $delete_id")) {

        echo "<script>
            alert('Account deleted successfully');
            window.location.href='accounts.php';
        </script>";
        exit();

    } else {
        echo "<script>alert('Delete failed');</script>";
    }
}

$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? 'name';

$sql = "SELECT 
            a.account_id,
            a.account_number,
            a.account_type,
            a.balance,
            a.status,
            c.full_name,
            b.branch_name
        FROM accounts a
        JOIN customers c ON a.customer_id = c.customer_id
        LEFT JOIN branches b ON a.branch_code = b.branch_code";

if (!empty($search)) {
    if ($filter == "account_no") {
        $sql .= " WHERE a.account_number LIKE '%$search%'";
    } else {
        $sql .= " WHERE c.full_name LIKE '%$search%'";
    }
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accounts</title>

    <style>
      body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f4f6f9;
}

/* LAYOUT */
.container {
    display: flex;
}

/* SIDEBAR */
.sidebar {
    width: 240px;
    background: #0d1b2a;
    color: white;
    min-height: 100vh;  /* ✅ grows with content */
    padding: 20px;
}

.sidebar h2 {
    margin-bottom: 20px;
    font-size: 20px;
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 10px;

    color: #cbd5e1;
    padding: 12px;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.2s;
}

.sidebar a:hover,
.sidebar a.active {
    background: #1b263b;
    color: #fff;
}

/* MAIN */
.main {
    flex: 1;
    padding: 25px;
}

/* CARD */
.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* HEADER ALIGN */
.card h2 {
    margin-bottom: 15px;
}

/* CREATE BUTTON */
.create-btn {
    background: #2ecc71;
    color: white;
    padding: 10px 16px;
    text-decoration: none;
    border-radius: 6px;
    display: inline-block;
    margin-bottom: 15px;
}

/* SEARCH BAR */
.top-bar {
    display: flex;
    justify-content: flex-end;
}

.search-group {
    display: flex;
    align-items: center;
    gap: 10px;

    background: #f9fafb;
    padding: 8px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
}

/* INPUT */
.search-group input {
    padding: 10px;
    border: none;
    outline: none;
    background: transparent;
    min-width: 200px;
}

/* SELECT */
.search-group select {
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ddd;
    background: white;
}

/* 🔵 BLUE SEARCH BUTTON */
.search-group button {
    background:#0d1b2a; /* BLUE */
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s;
}

.search-group button:hover {
    background: #1d4ed8;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    text-align: left;
}

th {
    background: #f8fafc;
    font-weight: 600;
}

/* BUTTONS */
.edit-btn {
    background: #3498db;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 6px;
    font-size: 13px;

    margin-right: 10px;  /* 👈 adds gap */
}

.delete-btn {
    background: #e74c3c;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
    </style>
</head>

<body>

<div class="container">

    <div class="sidebar">
    <h2>🏦 Admin</h2>
    <a href="admin_dashboard.php" >📊 Dashboard</a>
    <a href="customers.php">👤 Customers</a>
    <a href="accounts.php" class="active">💳 Accounts</a>
    <a href="branches.php">🏢 Branches</a>
    <a href="loans.php">📄 Loans</a>
</div>

    <!-- MAIN -->
    <div class="main">

        <!-- HEADER -->
        <div class="card">
            <h2>Accounts</h2>

            <a href="create_account.php" style="
                background:#2ecc71;
                color:white;
                padding:8px 15px;
                text-decoration:none;
                border-radius:6px;
                float:left;
                margin-bottom:10px;">
                + Create Account
            </a>

            <div class="top-bar">
                <form method="GET" class="search-group">
                    <input type="text" name="search" placeholder="Search..."
                        value="<?php echo htmlspecialchars($search); ?>">

                    <select name="filter">
                        <option value="name" <?php if($filter=="name") echo "selected"; ?>>Name</option>
                        <option value="account_no" <?php if($filter=="account_no") echo "selected"; ?>>Account No</option>
                    </select>

                    <button type="submit">Search</button>
                </form>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Account No</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Balance</th>
                    <th>Status</th>
<th>Branch</th>
<th>Actions</th>
                </tr>

                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['account_id']; ?></td>
                            <td><?php echo $row['account_number']; ?></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['account_type']; ?></td>
                            <td><?php echo $row['balance']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['branch_name']; ?></td>

                            <td>
                                <!-- EDIT -->
                                <a href="create_account.php?edit_id=<?php echo $row['account_id']; ?>" class="edit-btn">
                                    Edit
                                </a>

                                <!-- DELETE -->
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['account_id']; ?>">
                                    <button type="submit" name="delete" class="delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this account?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7">No records found</td></tr>
                <?php endif; ?>

            </table>
        </div>

    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("closed");
}
</script>

</body>
</html>