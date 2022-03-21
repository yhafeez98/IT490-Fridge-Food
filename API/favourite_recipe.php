<?php

require "../db/config.php";
require "../include/api_session_check.php";
$auth = $_SESSION['auth'];
$id = isset($_POST['id']) ? $_POST['id'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : null;
if (is_null($id)) {
    echo json_encode(['status' => 'error', 'message' => 'ID Is Required']);
    exit;
}
if ($status == "add") {
    $response = $db->insert(
        'favourite_recipe',
        [
            'recipe_id' => $id,
            'user_id' => $auth->id,
        ]
    );
    $message = 'Recipe Added To Favourite List Successfully';
}

if ($status == "remove") {
    $response = $db->delete(
        'favourite_recipe',
        "id",
        "$id"
    );
    $message = 'Recipe Removed from Favourite List Successfully';
}

if ($response['status'] == 'success') {
    echo json_encode(['status' => 'success', 'message' => $message]);
    exit;
}

if ($response['status'] == 'error') {
    echo json_encode(['status' => 'error', 'message' => $response['error']]);
    exit;
}
?>
