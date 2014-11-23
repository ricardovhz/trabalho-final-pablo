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
				<li><a href="vendas.php">Vendas</a></li>
				<li class="active"><a href="pessoas.php">Pessoas</a></li>
				<li><a href="veiculos.php" >Veiculos</a></li>
				<li><a href="usuarios.php">Usuarios</a></li>
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
				<div class="panel-heading">Pessoas Cadastradas</div>
				<div class="navbar navbar-default">
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<button class="btn btn-primary" data-toggle="modal" data-target="#modal-novo">Novo</button>
						</ul>
					</div>
				</div>
				<table class="table table-stripped table-hover" id="table-pessoas">
					<thead>
						<tr>
							<th>CPF</th>
							<th>Nome</th>
							<th>Data nascimento</th>
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
					Nova Pessoa
				</div>
				<div class="modal-body">
					<form role="form" action="engine.php" method="post">
						<input type="hidden" name="action" value="nova_pessoa" />
						<div class="form-group">
							<label for="cpf">CPF</label>
							<input type="text" placeholder="CPF" name="cpf" />
						</div>
						<div class="form-group">
							<label for="nome">Nome</label>
							<input type="text" placeholder="Nome" name="nome" />
						</div>
						<div class="form-group">
							<label for="rg">RG</label>
							<input type="text" placeholder="RG" name="rg" />
						</div>
						<div class="form-group">
							<label for="endereco">Endereco</label>
							<input type="text" placeholder="Endereco completo" name="endereco" />
						</div>
						<div class="form-group">
							<label for="data_nasc">Data nascimento</label>
							<input type="text" placeholder="Data de nascimento" name="data_nasc" />
						</div>
						<button class="btn btn-primary" type="submit">Ok</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" role="dialog" id="modal-update">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" type="button">&times;</button>
					Atualizar Pessoa
				</div>
				<div class="modal-body">
					<form role="form" action="engine.php" method="post">
						<input type="hidden" name="action" value="atualizar_pessoa" />
						<div class="form-group">
							<label for="atualizar_cpf">CPF</label>
							<input type="text" disabled="true" id="atualizar_cpf" name="cpf" />
						</div>
						<div class="form-group">
							<label for="atualizar_nome">Nome</label>
							<input type="text" placeholder="Nome" name="nome" id="atualizar_nome" />
						</div>
						<div class="form-group">
							<label for="atualizar_rg">RG</label>
							<input type="text" disabled="true" id="atualizar_rg" />
						</div>
						<div class="form-group">
							<label for="atualizar_endereco">Endereco</label>
							<input type="text" placeholder="Endereco" name="endereco" id="atualizar_endereco" />
						</div>
						<div class="form-group">
							<label for="atualizar_data_nasc">Data nascimento</label>
							<input type="text" placeholder="Data de nascimento" name="data_nasc" id="atualizar_data_nasc" />
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
			obterPessoas();
		});
		function obterVendedorLogado() {
			lib.obterVendedorLogado(function(vendedor) {
				$("#bem-vindo-vendedor").append("<b>"+vendedor.nome+"!</b>");
			});
		}
		function obterPessoas() {
			lib.obterPessoas(function(pessoas){
				var html = "";
				for (var i=0;i<pessoas.length;i++) {
					var item = pessoas[i];
					html += "<tr data-id='"+item.codigo+"'>";
					html += "<td>"+item.cpf+"</td>";
					html += "<td>"+item.nome+"</td>";
					html += "<td>"+item.data_nasc+"</td>";
					html += "<td><button class='btn btn-default' type='button' data-toggle='modal' data-target='#modal-update' onclick='prepareUpdate("+JSON.stringify(item)+")' title='Atualizar'><span class='glyphicon glyphicon-retweet'></span></button><button class='btn btn-default' type='button' onclick='deletarPessoa(\""+item.cpf+"\")' title='Deletar'><span class='glyphicon glyphicon-remove-sign'></span></button></td>";
				}
				$("#table-pessoas tbody").html(html);
			});
		}

		function deletarPessoa(cpf) {
			lib.deletarPessoa(cpf, function() {
				obterPessoas();
			});	
		}
		
		function prepareUpdate(item) {
			$("#atualizar_cpf").attr("value",item.cpf);
			$("#atualizar_nome").prop("value",item.nome);
			$("#atualizar_rg").prop("value",item.rg);
			$("#atualizar_endereco").prop("value",item.endereco);
			$("#atualizar_data_nasc").prop("value",item.data_nasc);
		}
	</script>
</body>

</html>
