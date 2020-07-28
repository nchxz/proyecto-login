<?php

session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
}

$errores = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario  = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password = hash('sha512', $password);

    try {
        $conect = new PDO('mysql:host=localhost;dbname=login_practica', 'root', '');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        die();
    }

    $statements = $conect->prepare('SELECT * FROM usuarios WHERE usuario = :usuario AND password = :password');
    $statements->execute(array('usuario' => $usuario, 'password' => $password));

    $resultado = $statements->fetch();

    if ($resultado !== false) {
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
    } else {
        $errores .= '<li>El usuario o contraseña estan incorrectos!</li>';
    }

}

require 'views/login.view.php';
