<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

if (isset($_GET["id"])) {
    $stmt = $pdo->prepare("SELECT * FROM `news` WHERE `id`=:id");
    $stmt->bindValue("id", $_GET["id"]);
    $stmt->execute();
    $news = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($news) {
        $stmt = $pdo->prepare("DELETE FROM `news` WHERE `id`=:id");
        $stmt->bindValue("id", $_GET["id"]);
        $stmt->execute();
        echo json_encode(array("status" => true));
    } else {
        echo json_encode(array("status" => false));
    }
}