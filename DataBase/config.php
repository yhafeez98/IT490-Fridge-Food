<?php

require "db.php";
$db = new db();
date_default_timezone_set("UTC");
function uploadImage($file, $upload_path)
{
    if (!isset($file)) {
        return false;
    }

    $fileTmpPath = $file['tmp_name'];
    $fileName = $file['name'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // sanitize file-name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    // check if file has one of the following extensions
    $allowedfileExtensions = array('png', 'jpg', 'jpeg');
    if (!in_array($fileExtension, $allowedfileExtensions)) {
        $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
        return json_encode(['status' => 'error', 'message' => $message]);
    }

    // Validate image file size
    if (($file["size"] > 2000000)) {
        $response = array("status" => "error", "message" => "Image size exceeds 2MB");
        return json_encode(['status' => 'error', 'message' => $response]);
    }

    // directory in which the uploaded file will be moved
    $dest_path = '../' . $upload_path . $newFileName;

    if (move_uploaded_file($fileTmpPath, $dest_path)) {
        return $upload_path . $newFileName;
    }

    return json_encode(['status' => 'error', 'message' => "File not uploaded"]);
}

?>
