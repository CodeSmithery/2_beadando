<h2>Belépés</h2>

<form method="POST" action="index.php?page=login">
    <label>Felhasználónév:</label>
    <input type="text" name="username" required>

    <label>Jelszó:</label>
    <input type="password" name="password" required>

    <button type="submit">Belépés</button>
</form>

<p>Nincs még fiókod? <a href="index.php?page=register">Regisztráció</a></p>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require "includes/db.php";

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Felhasználó lekérése
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Ellenőrzés
    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = [
            'lastname'  => $user['lastname'] ?? '',
            'firstname' => $user['firstname'] ?? '',
            'username'  => $user['username']
        ];

        echo "<p class='success-message'>Sikeres bejelentkezés! Átirányítás...</p>";

        header("Refresh: 1; URL=index.php");
        return;

    } else {
        echo "<p class='error-message'>Hibás felhasználónév vagy jelszó!</p>";
    }
}
