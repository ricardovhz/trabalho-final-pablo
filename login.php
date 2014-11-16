<?php

require_once('conexao.php');

$username = mysql_escape_string($_POST['username']);
$senha = $_POST['password'];

$senha_sha1 = sha1($senha);

$res = mysql_query("select * from usuario where nome_usuario='" . $username . "' and senha='" . $senha_sha1 . "'",$con);

if (mysql_num_rows($res) > 0) {
	$ar = mysql_fetch_assoc($res);
	session_start();
	$_SESSION['usuario'] = $ar['nome_usuario'];
	$_SESSION['id_vendedor'] = $ar['id_vendedor'];
	header('location: vendas.php');
} else {
	header('location: login-page.php?erro=true');
}

?>
