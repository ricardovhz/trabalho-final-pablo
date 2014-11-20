<?php
	require_once('verify_session.php');
?>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/layout.css">
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="vendas.php" >Vendas</a></li>
				<li><a href="pessoas.php">Pessoas</a></li>
				<li><a href="veiculos.php">Veiculos</a></li>
				<li class="active"><a href="usuarios.php">Usuarios</a></li>
			</ul>
			<ul class="nav navbar-right">
				<li><a href="logout.php"><span class="glyphicon glyphicon-log-out" title="Logout" aria-hidden="true"></span></a></li>
			</ul>
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-offset-0">
				<h3 id="bem-vindo-vendedor">Bem vindo </h3>
			</div>
		</div>
		<div class="alert alert-dismissible msg-erro-hide" role="alert" id="alert-principal">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
		</div>
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">Seus usuarios</div>
				<div class="navbar navbar-default">
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<button class="btn btn-primary" data-toggle="modal" data-target="#modal-novo">Novo</button>
						</ul>
					</div>
				</div>
				<table class="table table-stripped table-hover" id="table-usuarios">
					<thead>
						<tr>
							<th>Nome de Usuario</th>
							<th>#</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>	
			</div>
		</div>
	</div>

	<div class="modal fade" role="dialog" id="modal-novo">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" type="button">&times;</button>
					Nova Venda
				</div>
				<div class="modal-body">
					<form role="form" action="engine.php" method="post">
						<input type="hidden" name="action" value="novo_usuario" />
						<div class="form-group">
							<label for="nome">Nome de usuario</label>
							<input type="text" id="nome" name="nome" />
						</div>
						<div class="form-group">
							<label for="password">Senha</label>
							<input type="password" id="password" name="password" />
						</div>
						<button class="btn btn-primary" type="submit">Ok</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/lib.js"></script>
	<script>
		$(document).ready(function() {
			lib.checkForMessages("#alert-principal");
			obterVendedorLogado();
			obterUsuarios();
		});
		function obterVendedorLogado() {
			lib.obterVendedorLogado(function(vendedor) {
				$("#bem-vindo-vendedor").append("<b>"+vendedor.nome+"!</b>");
			});
		}
		function obterUsuarios() {
			lib.obterUsuarios(function(usuarios) {
				var html = "";
				for (var i=0;i<usuarios.length;i++) {
					var item = usuarios[i];
					html += "<tr data-id='"+item.nome_usuario+"'>";
					html += "<td>"+item.nome_usuario+"</td>";
					html += "<td><button class='btn btn-default' type='button' onclick='deletarUsuario(\""+item.nome_usuario+"\")' title='Deletar'><span class='glyphicon glyphicon-remove-sign'></span></button></td>";	
					html += "</tr>";
				}
				$("#table-usuarios tbody").html(html);
			});
		}
		function deletarUsuario(nome) {
			lib.deletarUsuario(nome, function() {
				obterUsuarios();
			});	
		}
	</script>
</body>

</html>
