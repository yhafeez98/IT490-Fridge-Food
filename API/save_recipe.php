<?php

require "../db/config.php";
require "../include/api_session_check.php";
$user = $_SESSION['auth'];
$title = isset($_POST['title']) && !empty(trim($_POST['title'])) ? trim($_POST['title']) : null;
$ready_in_minutes = isset($_POST['ready_in_minutes']) && !empty(trim($_POST['ready_in_minutes']))
    ? trim($_POST['ready_in_minutes'])
    : null;
$summary = isset($_POST['summary']) && !empty(trim($_POST['summary'])) ? trim($_POST['summary']) : null;
$servings = isset($_POST['servings']) && !empty(trim($_POST['servings'])) ? trim($_POST['servings']) : null;
$cuisines = isset($_POST['cuisines']) && !empty(trim($_POST['cuisines'])) ? trim($_POST['cuisines']) : null;
$status = isset($_POST['status']) && $_POST['status'] == 'on'
    ? 1 : 0;
$file = $_FILES['image'];
$upload_path = "assets/recipe_images/";
$image = uploadImage($file, $upload_path);

if (isset($image['status']) && $image['status'] == 'error') {
    echo $image;
    exit;
}

$response = $db->insert(
    'recipes',
    [
        'title' => $title,
        'ready_in_minutes' => $ready_in_minutes,
        'summary' => $summary,
        'image' => $image,
        'servings' => $servings,
        'cuisines' => $cuisines,
        'status' => $status,
        'user_id' => $user->id,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]
);

if ($response['status'] == 'success') {
    echo json_encode(['status' => 'success', 'message' => 'Data Inserted Successfully']);
    exit;
}

if ($response['status'] == 'error') {
    echo json_encode(['status' => 'error', 'message' => $response['error']]);
    exit;
}

?>
