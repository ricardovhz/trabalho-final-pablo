<?php

session_start();

$usuario = $_SESSION['usuario'];
$id_vendedor = $_SESSION['id_vendedor'];

if (!isset($usuario)) {
	header('location: login-page.php');
	session_destroy();
	die('sessão não iniciada');
}

?>
