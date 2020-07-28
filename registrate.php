<?php

session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
    /* Saneamos la variable para que no pueda ejecutarse codigo malicioso y la pasamos a minusculas para guardarla en la base de datos*/
    $password  = $_POST['password'];
    $password2 = $_POST['password2'];

    $errores = "";

    if (empty($usuario) || empty($password) || empty($password2)) {
        $errores .= "<li>Ingresa los valores correctamente!</li>";
    } else {
        try {
            $conect = new PDO('mysql:host=localhost;dbname=login_practica', 'root', '');
            // echo "Conect succes! :D";
        } catch (PDOException $e) {
            echo "Error! " . $e->getMessage();
            die();
        }

        $statements = $conect->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
        $statements->execute(array(':usuario' => $usuario));

        $consulta = $statements->fetch();

        //var_dump($consulta);

        if ($consulta != false) {
            $errores .= "El usuario ya existe!";
        }
    }

    $password  = hash('sha512', $password);
    $password2 = hash('sha512', $password2);

    if ($password != $password2) {
        $errores .= "Las contraseñas no son iguales!";
    }

    if ($errores == '') {
        $statements = $conect->prepare('INSERT INTO usuarios (id,usuario,password) VALUES (null, :usuario, :password)');
        $statements->execute(array(':usuario' => $usuario, ':password' => $password));

        header('Location: login.php');
    }
}

require 'views/registrate.view.php';
