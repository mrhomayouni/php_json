<?php
// {
// 	"status": false,
// 	"error": "Username or password is incorrect"
// }

// {
// 	"status": true,
//     "name": "Real name"
// }

// {
// 	"status": false,
// 	"error": "Reqruied fields are missing"
// }

// PDO Connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

if (isset($_GET["username"], $_GET["password"])) {
    $username = trim($_GET["username"]);
    $password = trim($_GET["password"]);
    $name = trim($_GET["name"]);

    if ($username === "" | $password === "" | $name === "") {
        echo json_encode(array("status" => false, "error" => "Fields are empty!"));
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            echo json_encode(array("status" => false, "username" => $result["username"], "message" => "exist this user"));
        } else {
            $stmt = $pdo->prepare("INSERT INTO `users`(`username`, `name`, `password`) VALUES (:username,:name,:password )");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":name", $name);
            $user = $stmt->execute();
/*            echo "___________";*/
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username0");
            $stmt->bindParam(":username0", $username);
            $stmt->execute();
            $user = $stmt->fetch();
            echo json_encode(array("status" => true, "massage" => "welcome " . $user["name"]));

        }
    }
} else {
    echo json_encode(array("status" => false, "error" => "Required fields are missing"));
}