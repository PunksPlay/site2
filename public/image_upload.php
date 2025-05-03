<?php
// public/image_upload.php

// Разрешаем кроссдоменные куки, если нужно
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);

if (empty($_FILES['file'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded.']);
    exit;
}

$file      = $_FILES['file'];
$ext       = pathinfo($file['name'], PATHINFO_EXTENSION);
$allowed   = ['jpg','jpeg','png','gif','webp'];
if (!in_array(strtolower($ext), $allowed, true)) {
    http_response_code(415);
    echo json_encode(['error' => 'Invalid image type.']);
    exit;
}

// Папка для загрузок (должна существовать и быть доступной для записи)
$uploadDir = __DIR__ . '/../assets/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$filename  = uniqid() . '.' . $ext;
$target    = $uploadDir . $filename;

if (!move_uploaded_file($file['tmp_name'], $target)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to move uploaded file.']);
    exit;
}

// Вернём JSON, как хочет TinyMCE
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'location' => '/assets/uploads/' . $filename
]);
