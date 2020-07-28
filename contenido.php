<?php

session_start();

if (isset($_SESSION['usuario'])) {

    require 'views/contenido.view.php';

} else {
    header('Location: login.php');
}

/* Si existe una session iniciada entonces el usuario va a poder ver el contenido de la pagina sino es redireccionado*/
