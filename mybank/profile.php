<?php
session_start();
include "db.php";

/* GET LOGGED USER */
$username = $_SESSION['customer'];

/* GET CUSTOMER DETAILS */
$sql = "
SELECT c.*
FROM customers c
JOIN customer_login l
ON c.customer_id = l.customer_id
WHERE l.username = '$username'
";

$result = $conn->query($sql);
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
<title>Customer Profile</title>

<style>

body{
    font-family:'Inter', Arial, sans-serif;
    margin:0;
    height:100vh;

    background:
    linear-gradient(135deg,#f1f5f9,#e2e8f0);

    display:flex;
    justify-content:center;
    align-items:center;
}

/* CONTAINER (WIDER NOW) */
.container{
    width:900px;
    max-width:95%;
}

/* CARD */
.card{
    background:white;
    padding:40px;
    border-radius:14px;
    box-shadow:0 15px 40px rgba(0,0,0,0.12);
}

/* HEADER */
.header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:30px;
}

.header-left{
    display:flex;
    align-items:center;
    gap:15px;
}

/* AVATAR */
.avatar{
    width:55px;
    height:55px;
    background:#97144d;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    font-size:20px;
    font-weight:bold;
}

h2{
    margin:0;
    color:#0f172a;
}

/* GRID INFO (LIKE IMAGE 2 STYLE) */
.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
    margin-top:20px;
}

.info-box{
    background:#f8fafc;
    padding:15px;
    border-radius:10px;
    border:1px solid #e2e8f0;
}

.label{
    font-size:13px;
    color:#64748b;
    margin-bottom:5px;
}

.value{
    font-size:15px;
    font-weight:500;
    color:#0f172a;
}

/* BUTTON */
.btn{
    margin-top:30px;
    padding:12px 20px;
    background:#97144d;
    border:none;
    color:white;
    border-radius:8px;
    cursor:pointer;
    font-weight:500;
    transition:0.3s;
}

.btn:hover{
    background:#7a103d;
}

/* BACKGROUND GLOW */
body::before,
body::after{
    content:"";
    position:fixed;
    border-radius:50%;
    filter:blur(120px);
    z-index:0;
    pointer-events:none;
}

body::before{
    width:400px;
    height:400px;
    background:#97144d33;
    top:-120px;
    right:-120px;
}

body::after{
    width:350px;
    height:350px;
    background:#0ea5e933;
    bottom:-120px;
    left:-120px;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

<!-- HEADER -->
<div class="header">

<div class="header-left">
    <div class="avatar">
        <?php echo strtoupper(substr($data['full_name'],0,1)); ?>
    </div>
    <h2>Customer Profile</h2>
</div>

<button class="btn" onclick="back()">← Back</button>

</div>

<!-- INFO GRID -->
<div class="info-grid">

<div class="info-box">
    <div class="label">Full Name</div>
    <div class="value"><?php echo $data['full_name']; ?></div>
</div>

<div class="info-box">
    <div class="label">Email</div>
    <div class="value"><?php echo $data['email']; ?></div>
</div>

<div class="info-box">
    <div class="label">Phone</div>
    <div class="value"><?php echo $data['phone']; ?></div>
</div>

<div class="info-box">
    <label>Address</label>
    <p><?php echo $data['address'] ?? '-'; ?></p>
</div>

<div class="info-box">
    <label>Date Of Birth</label>
    <p><?php echo $data['dob'] ?? '-'; ?></p>
</div>

</div>

</div>

</div>

<script>
function back(){
    window.location.href="dashboard.php";
}
</script>

</body>
</html>