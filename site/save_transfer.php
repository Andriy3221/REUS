<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$file = 'transfers.json';

// Якщо файлу немає, створюємо його
if (!file_exists($file)) {
    file_put_contents($file, '[]');
}

// Пробуємо дати файлу повні права на запис
@chmod($file, 0777);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    
    if (!empty($input)) {
        $bytesWritten = @file_put_contents($file, $input);
        
        if ($bytesWritten !== false) {
            echo json_encode(["status" => "success"]);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "Помилка запису у файл transfers.json"]);
            exit;
        }
    }
}

echo json_encode(["status" => "error", "message" => "Невірний метод запиту"]);
?>