<?php

session_start();
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] == false) {
    echo json_encode(["status" => "error", "message" => "Unauthorized Access"]);
    exit;
}
?>
