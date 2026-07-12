<?php
include "db.php";

if (isset($_GET['id'])) {

    $id = intval($_GET['id']); // secure

    // First delete related loans
    $conn->query("DELETE FROM loans WHERE account_id = $id");

    // Then delete account
    $conn->query("DELETE FROM accounts WHERE account_id = $id");

    echo "<script>
        alert('Deleted successfully');
        window.location.href='admin_dashboard.php';
    </script>";

} else {
    header("Location: admin_dashboard.php");
}
?>