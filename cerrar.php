<?php

session_start();

session_destroy(); // Destruimos la session

$_SESSION = array(); // Limpaimos la session pasandole un array vacio como valor

header('Location: login.php'); // Redireccionamos al usuario al login luego de cerrar la session
