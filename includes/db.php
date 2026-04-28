/*
    Az adatbázis kapcsolatot létrehozó fájl (PDO).
    Ezt az api.php és a login/regisztrációs oldalak használják.
*/

<?php
$host = "localhost";
$db   = "varosadatbazis";
$user = "root";
$pass = "NJEBeadando2lab";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=UTF8",$user,$pass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
} catch (PDOException $e) {
    die("Database connection failed");
}
