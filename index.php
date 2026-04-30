<?php
session_start();

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

include "includes/header.php";

if ($page == "home") {
    include "home.php";
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
elseif ($page == "messages") {
    include "messages.php";
}
elseif ($page == "message_view") {
    include "messages_view.php";
}
else {
    echo "404 - Nincs ilyen oldal";
}

include "includes/footer.php";
