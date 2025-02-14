<?php

$image_name = isset($_GET['image']) ? $_GET['image'] : '';

$path = __DIR__ . '/../images/news/' . basename($image_name); 

if (file_exists($path)) {
    header('Content-Type: image/jpeg'); 
    readfile($path);
    exit;
} else {
    http_response_code(404);
    echo 'File not found: ' . htmlspecialchars($path);
}
?>
