<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Weboldal</title>
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

<?php if (isset($_SESSION['user'])): ?>
    <p>Bejelentkezett: <?= $_SESSION['user'] ?></p>
<?php endif; ?>
