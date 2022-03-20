<?php

session_start();
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] == false) {
    header('location: login.php');
    exit;
}
?>
