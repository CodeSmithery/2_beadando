<h2>Regisztráció</h2>

<form method="POST" action="register.php">
    <label>Teljes név:</label><br>
    <input type="text" name="fullname" required><br><br>

    <label>Felhasználónév:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Jelszó:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Regisztráció</button>
</form>

<p>Már van fiókod? <a href="index.php?page=login">Belépés</a></p>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require "includes/db.php";

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Ellenőrzés: létezik-e már a felhasználónév
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        echo "<p style='color:red;'>Ez a felhasználónév már foglalt!</p>";
        return;
    }

    // Jelszó hash-elése
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Mentés
    $stmt = $pdo->prepare("
        INSERT INTO users (fullname, username, email, password)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$fullname, $username, $email, $hashed]);

    echo "<p style='color:green;'>Sikeres regisztráció! Átirányítás...</p>";

    header("Refresh: 2; URL=index.php?page=login");
    exit;
}
?>
