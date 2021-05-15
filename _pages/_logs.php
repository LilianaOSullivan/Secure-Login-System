<?php
    session_start();
    require_once("helpers/db.php");
    require_once("helpers/session.php");
    must_be_admin($conn);
    check_activity_expiration();
    require_once("helpers/security.php");

    $sql = "SELECT id,action,ip,timestamp,outcome FROM `logs` ORDER BY timestamp DESC";
    $stmt = $conn->prepare($sql);
    if(!$stmt->execute()) {
        die("This action is currently inaccessible");
    }
    $result = $stmt->get_result();
?>