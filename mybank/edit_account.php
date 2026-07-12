<?php
include "db.php";

$id = intval($_GET['id']);

$data = $conn->query("
    SELECT 
        a.*,
        b.branch_name
    FROM accounts a
    LEFT JOIN branches b 
    ON a.branch_code = b.branch_code
    WHERE a.account_id=$id
")->fetch_assoc();


?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Account</title>

    <style>
        body {
            margin: 0;
            padding: 40px;
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container {
            max-width: 420px;
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background: #f9fafb;
            transition: 0.2s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;

            background: #2563eb;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>

<div class="form-container">



    <h2>Edit Account</h2>

    <form action="update_account.php" method="POST">

        <input type="hidden" name="account_id" value="<?php echo $data['account_id']; ?>">

        <div class="form-group">
            <label>Account Number</label>
            <input type="text" name="account_number" value="<?php echo $data['account_number']; ?>">
        </div>

        <div class="form-group">
    <label>Account Type</label>

    <select name="account_type">
        <option <?php if($data['account_type']=='SAVINGS') echo 'selected'; ?>>
            SAVINGS
        </option>

        <option <?php if($data['account_type']=='CURRENT') echo 'selected'; ?>>
            CURRENT
        </option>
    </select>

</div>

        <div class="form-group">
            <label>Balance</label>
            <input type="text" name="balance" value="<?php echo $data['balance']; ?>">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option <?php if($data['status']=='ACTIVE') echo 'selected'; ?>>ACTIVE</option>
                <option <?php if($data['status']=='BLOCKED') echo 'selected'; ?>>BLOCKED</option>
            </select>
        </div>

        <div class="form-group">
    <label>Branch</label>
    <input type="text" value="<?php echo $data['branch_name']; ?>" readonly>
</div>

        <button type="submit">Update</button>

    </form>

</div>

</body>
</html>