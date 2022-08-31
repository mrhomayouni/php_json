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

    if ($username === "" | $password === "") {
        echo json_encode(array("a" => false, "error" => "Fields are empty!"));
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            echo json_encode(array("a" => true, "username" => $result["username"]));
        } else {
            echo json_encode(array("a" => false, "error" => "Username or password is incorrect"));
        }
    }
} else {
    echo json_encode(array("a" => false, "error" => "Required fields are missing"));
}
echo "<br>";
var_dump(json_decode('{"status":false,"error":"Fields are empty!"}'));