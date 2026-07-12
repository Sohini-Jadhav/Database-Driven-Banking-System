<?php
session_start();
include "db.php";

$customer_id = $_SESSION['customer_id'];

$result = $conn->query("SELECT account_number FROM accounts WHERE customer_id = $customer_id");
$row = $result->fetch_assoc();

$sender_account = $row['account_number'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Transfer Money</title>

<!-- ✅ SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* (YOUR CSS SAME — no changes) */
body{
    font-family: 'Inter', Arial, sans-serif;
    margin:0;
    height:100vh;

    background:
    linear-gradient(135deg, #f1f5f9, #e2e8f0),
    repeating-linear-gradient(
        45deg,
        rgba(0,0,0,0.02) 0px,
        rgba(0,0,0,0.02) 1px,
        transparent 1px,
        transparent 10px
    );

    display:flex;
    flex-direction:column;
}

/* BACKGROUND DECORATION */
body::before{
    content:"";
    position:fixed;
    width:400px;
    height:400px;
    background:rgba(151,20,77,0.15);
    top:-100px;
    right:-100px;
    border-radius:50%;
    filter:blur(100px);
    z-index:0;
}

body::after{
    content:"";
    position:fixed;
    width:300px;
    height:300px;
    background:rgba(14,165,233,0.15);
    bottom:-100px;
    left:-100px;
    border-radius:50%;
    filter:blur(100px);
    z-index:0;
}

/* HEADER */
.header{
    background:#0b1a2f;
    color:white;
    padding:16px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    position: relative;
    z-index: 10;

    
}

.back-btn{
    background:#97144d;
    color:white;
    padding:10px 18px;
    border-radius:8px;
    text-decoration:none;
}

/* CONTAINER */
.container{
    width:420px;
    margin:70px auto;
    background:white;
    padding:30px 28px;
    border-radius:12px;
    box-shadow:0 10px 40px rgba(0,0,0,0.15);
    position:relative;
    z-index:1;
}

label{
    font-size:13px;
    font-weight:600;
    margin-top:15px;
    display:block;
}

input{
    width:100%;
    padding:11px;
    margin-top:6px;
    border-radius:8px;
    border:1px solid #e2e8f0;
}

input[readonly]{
    background:#eef2f7;
    color:#555;
    cursor:not-allowed;
}

.transfer-btn{
    width:100%;
    margin-top:25px;
    padding:12px;
    background:#97144d;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

.security-box{
    margin-top:20px;
    background:#ecfdf5;
    padding:12px;
    border-radius:8px;
}
</style>
</head>

<body>

<div class="header">
<h2>🏦 Bank System</h2>
<button onclick="window.location.href='dashboard.php'" class="back-btn">
    ← Back
</button>
</div>

<div class="container">

<h2>Transfer Money</h2>

<form id="transferForm" action="process_transfer.php" method="POST">
<label>Sender Account Number</label>
<input
    type="text"
    name="sender_account"
    value="<?php echo $sender_account; ?>"
    readonly
    style="background:#f1f5f9; color:#555; cursor:not-allowed;">

<label>Receiver Account Number</label>
<input type="text" name="receiver_account" required>

<label>Amount</label>
<input type="number" name="amount" required>

<label>Remarks (Optional)</label>
<input type="text" name="remarks">

<button class="transfer-btn" type="submit">Transfer Money</button>

</form>

<div class="security-box">
🔒 Transactions are secured with bank-level encryption.
</div>

</div>

<script>

/* ✅ CONFIRM BEFORE TRANSFER */
document.getElementById("transferForm").addEventListener("submit", function(e){
    e.preventDefault();

    Swal.fire({
        title: "Confirm Transfer?",
        text: "Do you want to proceed with this transaction?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#97144d",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Yes, Transfer"
    }).then((result) => {
        if (result.isConfirmed) {

            /* ✅ LOADING */
            Swal.fire({
                title: "Processing...",
                text: "Please wait while we complete your transaction",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            /* submit after loader */
            setTimeout(() => {
                document.getElementById("transferForm").submit();
            }, 1000);
        }
    });
});

</script>

</body>
</html>