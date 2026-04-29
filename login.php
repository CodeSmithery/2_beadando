<h2>Belépés</h2>

<form method="POST" action="index.php?page=login">
    <label>Felhasználónév:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Jelszó:</label><br>
    <input type="password" name="password" required><br><br>

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

        $_SESSION['user'] = $user['username'];

        header("Location: index.php");
        exit;

    } else {
        echo "<p style='color:red;'>Hibás felhasználónév vagy jelszó!</p>";
    }
}
?>