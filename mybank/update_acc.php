<?php
include "db.php";

$id = intval($_POST['account_id']);
$acc = $_POST['account_number'];
$type = $_POST['account_type'];
$bal = $_POST['balance'];
$status = $_POST['status'];
$branch = $_POST['branch_code'];

$sql = "UPDATE accounts 
        SET 
        account_number='$acc',
        account_type='$type',
        balance='$bal',
        status='$status'
           branch_code='$branch'
        WHERE account_id=$id";

if($conn->query($sql)) {

    echo "<script>
    alert('Account Updated Successfully!');
    window.location.href='accounts.php';
    </script>";

} else {

    echo "Update Failed: " . $conn->error;

}
?>