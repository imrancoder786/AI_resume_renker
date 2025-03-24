<?php
$upload_dir = "resumes/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$uploaded_files = [];

foreach ($_FILES['resumes']['tmp_name'] as $key => $tmp_name) {
    $file_name = $_FILES['resumes']['name'][$key];
    $target_path = $upload_dir . basename($file_name);

    if (move_uploaded_file($tmp_name, $target_path)) {
        $uploaded_files[] = $target_path;
    }
}

echo json_encode(["message" => "Files uploaded successfully", "files" => $uploaded_files]);
?>
