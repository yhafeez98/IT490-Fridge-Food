<?php

require "../db/config.php";
require "../include/api_session_check.php";
$user = $_SESSION['auth'];

$id = isset($_POST['id']) && !empty(trim($_POST['id'])) ? trim($_POST['id']) : null;

if (is_null($id)) {
    echo json_encode(['status' => 'error', 'message' => 'ID Is Required']);
    exit;
}

$insert = $db->delete('recipes', "id", "$id");

if ($insert['status'] == 'success') {
    echo json_encode(['status' => 'success', 'message' => 'Data Deleted Successfully']);
    exit;
}
if ($insert['status'] == 'error') {
    echo json_encode(['status' => 'error', 'message' => $insert['error']]);
    exit;
}
