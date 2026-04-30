<?php

session_start();
require "includes/db.php";

$action = $_POST['action'] ?? null;

switch ($action) {

    case 'read':
        try {
            $stmt = $pdo->query("SELECT * FROM users");
            $readData = $stmt->fetchAll();
            echo json_encode(['status' => 'Read success!', 'readData' => $readData]);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'Read error!']);
        }
        break;

    case 'create':
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $stmt->execute([$_POST["name"], $_POST["email"]]);
            echo json_encode(['status' => 'Create success!']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'Create error!']);
        }
        break;

    case 'update':
        try {
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->execute([$_POST["name"], $_POST["email"], $_POST["id"]]);
            echo json_encode(['status' => 'Update success!']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'Update error!']);
        }
        break;

    case 'delete':
        try {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$_POST["id"]]);
            echo json_encode(['status' => 'Delete success!']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'Delete error!']);
        }
        break;

    case 'upload_image':

        if (!isset($_FILES['image'])) {
            echo json_encode(['status' => 'No file uploaded']);
            break;
        }

        $file = $_FILES['image'];
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            echo json_encode(['status' => 'Invalid file type']);
            break;
        }

        if ($file['size'] > 1 * 1024 * 1024) { // 1 MB limit
            echo json_encode(['status' => 'File too large']);
            break;
        }

        $newName = uniqid("img_") . "." . $ext;
        $target = "public/uploads/images/" . $newName;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            echo json_encode(['status' => 'Upload success']);
        } else {
            echo json_encode(['status' => 'Upload failed']);
        }

        break;

    case 'varos_create':
    $stmt = $pdo->prepare("
        INSERT INTO varos (nev, megyeid, megyeszekhely, megyeijogu)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([
        $_POST['nev'],
        $_POST['megyeid'],
        $_POST['megyeszekhely'],
        $_POST['megyeijogu']
    ]);

    header("Location: index.php?page=crud");
    exit;
    break;

    case 'contact_send':

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $msg = trim($_POST['message'] ?? '');

        if (strlen($name) < 3 || strlen($msg) < 5 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'Hibás adatok!']);
            break;
        }

        $userName = isset($_SESSION['user']) ? $_SESSION['user'] : "Vendég";

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO messages (name, email, message, created_at, user_name)
                 VALUES (?, ?, ?, NOW(), ?)"
            );
            $stmt->execute([$name, $email, $msg, $userName]);

            echo json_encode([
                'status'   => 'Üzenet elküldve!',
                'redirect' => 'index.php?page=message_view'
            ]);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'Mentési hiba!']);
        }

        break;
        case 'varos_update':
    $stmt = $pdo->prepare("
        UPDATE varos
        SET nev = ?, megyeid = ?, megyeszekhely = ?, megyeijogu = ?
        WHERE id = ?
    ");
    $stmt->execute([
        $_POST['nev'],
        $_POST['megyeid'],
        $_POST['megyeszekhely'],
        $_POST['megyeijogu'],
        $_POST['id']
    ]);

    header("Location: index.php?page=crud");
    exit;


    case 'varos_delete':
    $stmt = $pdo->prepare("DELETE FROM varos WHERE id = ?");
    $stmt->execute([$_POST['id']]);

    header("Location: index.php?page=crud");
    exit;

    default:
        echo json_encode(['status' => 'Invalid action']);
        break;
}
