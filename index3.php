<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM `news`");
$stmt->execute();
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);

$obj = [
    "status" => true,
    "item" => $news
];
echo json_encode($obj);
