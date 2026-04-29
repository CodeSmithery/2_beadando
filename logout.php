<?php
session_start();

// Minden session változó törlése
session_unset();

// Session teljes megsemmisítése
session_destroy();

// Visszairányítás a főoldalra
header("Location: index.php");
exit;
