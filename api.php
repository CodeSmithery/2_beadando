/*
    Ez az egyetlen fájl kezeli az összes háttérműveletet:

    CRUD műveletek (városok, megyék, lélekszám)

    kapcsolat űrlap mentése

    képfeltöltés

    bejelentkezés, regisztráció

    adatok lekérése AJAX‑hoz

    A JavaScript minden műveletet ehhez a fájlhoz küld POST vagy GET kéréssel.

*/


<?php
require "db.php";
$action = $_POST['action'];
switch ($action) {
    case 'read':  
        try {
            $stmt = $pdo->query("SELECT * FROM users");
            $readData=$stmt->fetchAll();
            echo json_encode(['status' => 'Read success!', "readData"=>$readData]);
        }
        catch(PDOException $e) {
          echo json_encode(['status' => 'Read error!']);
        }
        break;
    case 'create':
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $stmt->execute([$_POST["name"], $_POST["email"]]);
            echo json_encode(['status' => 'Create success!']);
        }
        catch(PDOException $e) {
          echo json_encode(['status' => 'Create error!']);
        }
        break;
    case 'update':
        try {
            $stmt = $pdo->prepare("UPDATE users SET name=?, email=? WHERE id=?");
            $stmt->execute([$_POST["name"], $_POST["email"], $_POST["id"]]);
            echo json_encode(['status' => 'Update success!']);
        }
        catch(PDOException $e) {
          echo json_encode(['status' => 'Update error!']);
        }
        break;
    case 'delete':
        try {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
            $stmt->execute([$_POST["id"]]);
            echo json_encode(['status' => 'Delete success!']);
        }
        catch(PDOException $e) {
          echo json_encode(['status' => 'Delete error!']);
        }
        break;
}
