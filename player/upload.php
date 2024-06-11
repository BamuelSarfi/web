<?php
session_start();
header('Content-Type: application/json');

$target_dir = "player/videos/";
$target_file = $target_dir . basename($_FILES["videoFile"]["name"]);
$uploadOk = 1;
$videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
    echo json_encode(["success" => false, "message" => "Sorry, file already exists."]);
    $uploadOk = 0;
}

// Check file size
if ($_FILES["videoFile"]["size"] > 50000000) {
    echo json_encode(["success" => false, "message" => "Sorry, your file is too large."]);
    $uploadOk = 0;
}

// Allow certain file formats
if($videoFileType != "mp4" && $videoFileType != "mov" && $videoFileType != "avi" && $videoFileType != "mkv") {
    echo json_encode(["success" => false, "message" => "Sorry, only MP4, MOV, AVI & MKV files are allowed."]);
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo json_encode(["success" => false, "message" => "Sorry, your file was not uploaded."]);
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["videoFile"]["tmp_name"], $target_file)) {
        $videoName = basename($_FILES["videoFile"]["name"]);
        echo json_encode(["success" => true, "videoName" => $videoName, "videoSrc" => $videoName]);
    } else {
        echo json_encode(["success" => false, "message" => "Sorry, there was an error uploading your file."]);
    }
}
?>
