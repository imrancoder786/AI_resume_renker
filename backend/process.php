<?php
require_once 'helpers.php';

$job_description = $_POST['job_description'];
$resume_files = glob("resumes/*");

$response_data = [];

foreach ($resume_files as $file) {
    $resume_text = extractText($file);
    $score = getScoreFromAI($resume_text, $job_description);
    $response_data[] = ["file" => basename($file), "score" => $score];
}

// Sort resumes by score
usort($response_data, function($a, $b) {
    return $b["score"] - $a["score"];
});

echo json_encode($response_data);
?>
