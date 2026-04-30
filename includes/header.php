<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Weboldal</title>
    <link rel="stylesheet" href="public/styles/main.css">
</head>
<body>

<h1>Weboldal</h1>

<nav>
    <a href="index.php">Főoldal</a> |
    <a href="index.php?page=pictures">Képek</a> |
    <a href="index.php?page=connection">Kapcsolat</a> |
    
    <?php if (isset($_SESSION['user'])): ?>
        <a href="index.php?page=crud">CRUD</a> |
        <a href="index.php?page=messages">Üzenetek</a> |
        <a href="index.php?page=logout">Kilépés</a>
    <?php else: ?>
        <a href="index.php?page=login">Belépés</a>
    <?php endif; ?>
</nav>

<hr>

<main class="page-content">

<?php if (isset($_SESSION['user'])): ?>
    <p>
        Bejelentkezett: 
        <?php if (is_array($_SESSION['user'])): ?>
            <?= htmlspecialchars(trim($_SESSION['user']['lastname'] . ' ' . $_SESSION['user']['firstname']), ENT_QUOTES, 'UTF-8') ?>
            (<?= htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8') ?>)
        <?php else: ?>
            <?= htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8') ?>
        <?php endif; ?>
    </p>
<?php endif; ?>
