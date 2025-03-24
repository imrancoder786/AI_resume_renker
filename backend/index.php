<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Google Gemini API Key (Replace with yours)
$GEMINI_API_KEY = "AIzaSyDRIpCXeLkIkXNhqBxNwM-0q47lB9tPObM"; // 🛑 Replace this with your API key

// 🟢 Handle File Upload
if (isset($_FILES["resume"])) {
    $uploadDir = "uploads/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create uploads folder if not exists
    }

    $filePath = $uploadDir . basename($_FILES["resume"]["name"]);
    if (move_uploaded_file($_FILES["resume"]["tmp_name"], $filePath)) {
        echo json_encode(["success" => "File uploaded successfully!", "filename" => basename($filePath)]);
    } else {
        echo json_encode(["error" => "Failed to upload file."]);
    }
    exit;
}

// 🟢 Handle Resume Ranking
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    $jd = $input["job_description"];

    // Read uploaded resumes
    $resumeTexts = [];
    foreach (glob("uploads/*.pdf") as $file) {
        $text = shell_exec("pdftotext $file -"); // Convert PDF to text
        $resumeTexts[] = ["filename" => basename($file), "text" => $text];
    }

    // 🟢 Build prompt for Gemini API
    $prompt = "Job Description:\n$jd\n\nRank these resumes based on relevance:\n";
    foreach ($resumeTexts as $resume) {
        $prompt .= "\n---\nResume: " . $resume["filename"] . "\n" . $resume["text"];
    }

    // 🟢 Call Google Gemini API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateText?key=$GEMINI_API_KEY");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["prompt" => ["text" => $prompt]]));

    $response = curl_exec($ch);
    curl_close($ch);

    // 🟢 Parse API Response (Mocking for now)
    $rankedResumes = [];
    foreach ($resumeTexts as $i => $resume) {
        $rankedResumes[] = ["filename" => $resume["filename"], "score" => rand(60, 100)]; // Mock AI response
    }
    usort($rankedResumes, fn($a, $b) => $b["score"] - $a["score"]); // Sort by score

    echo json_encode($rankedResumes);
    exit;
}

echo json_encode(["error" => "Invalid request"]);
?>
