<?php

$dbname = 'NewsBD';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=MySQL-8.0;dbname=$dbname;charset=utf8", $user, $password);

    $newsPerPage = 4;

    $totalStmt = $pdo->query("SELECT COUNT(*) FROM news");
    $totalNews = $totalStmt->fetchColumn();
    $totalPages = ceil($totalNews / $newsPerPage);

    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($currentPage < 1) {
        $currentPage = 1;
    } elseif ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    $offset = ($currentPage - 1) * $newsPerPage;

    $stmt = $pdo->prepare("SELECT * FROM news LIMIT :offset, :limit");
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $newsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        'total' => $totalNews,
        'per_page' => $newsPerPage, 
        'current_page' => $currentPage, 
        'total_pages' => $totalPages, 
        'posts' => $news 
    ];

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>
