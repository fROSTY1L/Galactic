<?php

$dbname = 'NewsBD';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=MySQL-8.0;dbname=$dbname;charset=utf8", $user, $password);

    $stmt = $pdo->query("SELECT * FROM news ORDER BY date DESC LIMIT 1");
    $latestNews = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($latestNews);

} catch (PDOException $e) {
    http_response_code(500);
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>
