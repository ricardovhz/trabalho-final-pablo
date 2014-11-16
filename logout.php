<?php
	session_start();
	session_destroy();
	unset($_SESSION['usuario']);
	unset($_SESSION['id_vendedor']);
	header('location: login-page.php');


?>
