<?php
	session_start();
	if (isset($_SESSION['usuario'])) {
		header('location: vendas.php');
		die('usuario já logado: ' . $usuario);
	}
?>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/layout.css">
</head>


<body>

	<div class="loginbox">
		<h3 class="titulo">Consórcio RvR</h3>
		<p class="bg-danger msg-erro-hide" id="msg-erro">Usuario/senha invalidos!</p>
		<form action="login.php" method="post">
			<div class="form-group">
				<label for="username">Usuário</label>
				<input type="text" id="username" class="form-control" name="username" placeholder="Digite seu usuário">
			</div>

			<div class="form-group">
				<label for="username">Senha</label>
				<input type="password" id="password" class="form-control" name="password" placeholder="Digite sua senha">
			</div>
			
			<button type="submit" value="Login" class="btn btn-primary">Login</button>
		</form>
	</div>

	<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script>
		$(document).ready(
			function() {
				if (window.location.search.contains('erro=true')) {
					$('#msg-erro').removeClass('msg-erro-hide');
				}
			}
		);
	</script>

</body>


</html>
