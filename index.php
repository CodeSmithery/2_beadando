/*
    A weboldal kezdőlapja. Itt jelenik meg a menü, a fő tartalom, a videók és a téma bemutatása. 
    A header.php és footer.php fájlokkal együtt épül fel.
*/

<?php
session_start();

$page = $_GET['page'] ?? 'home';

include "includes/header.php";

if ($page == "home") {
    echo "<h2>Főoldal</h2>";
}
elseif ($page == "crud") {
    include "crud.php";
}
elseif ($page == "login") {
    include "login.php";
}
elseif ($page == "register") {
    include "register.php";
}
elseif ($page == "logout") {
    include "logout.php";
}
elseif ($page == "pictures") {
    include "pictures.php";
}
elseif ($page == "connection") {
    include "connection.php";
}
else {
    echo "404 - Nincs ilyen oldal";
}

include "includes/footer.php";
?>