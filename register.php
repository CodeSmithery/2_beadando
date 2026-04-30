<h2>Regisztráció</h2>

<form method="POST" action="index.php?page=register">
    <label>Vezetéknév:</label>
    <input type="text" name="lastname" required>

    <label>Keresztnév:</label>
    <input type="text" name="firstname" required>

    <label>Felhasználónév:</label>
    <input type="text" name="username" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Jelszó:</label>
    <input type="password" name="password" required>

    <button type="submit">Regisztráció</button>
</form>

<p>Már van fiókod? <a href="index.php?page=login">Belépés</a></p>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require "includes/db.php";

    $lastname  = trim($_POST['lastname']);
    $firstname = trim($_POST['firstname']);
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = trim($_POST['password']);

    // Ellenőrzés: létezik-e már a felhasználónév
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        echo "<p class='error-message'>Ez a felhasználónév már foglalt!</p>";
        return;
    }

    // Jelszó hash-elése
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Mentés
    $stmt = $pdo->prepare("\n        INSERT INTO users (lastname, firstname, username, email, password)\n        VALUES (?, ?, ?, ?, ?)\n    ");
    $stmt->execute([$lastname, $firstname, $username, $email, $hashed]);

    echo "<p class='success-message'>Sikeres regisztráció! Átirányítás...</p>";

    header("Refresh: 2; URL=index.php?page=login");
    return;
}
