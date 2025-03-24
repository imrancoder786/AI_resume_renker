<?php
function extractText($file) {
    return file_get_contents($file); // Simplified (Use a library like PyPDF2 for PDFs)
}

function getScoreFromAI($resume, $job_description) {
    $api_key = "AIzaSyDRIpCXeLkIkXNhqBxNwM-0q47lB9tPObM";
    $url = "https://api.gemini.com/v1/score";

    $data = [
        "job_description" => $job_description,
        "resume_content" => $resume
    ];

    $options = [
        "http" => [
            "header"  => "Content-Type: application/json\r\nAuthorization: Bearer $api_key",
            "method"  => "POST",
            "content" => json_encode($data)
        ]
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return json_decode($result, true)["score"] ?? 0;
}
?>
