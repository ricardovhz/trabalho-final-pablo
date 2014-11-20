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
				<li><a href="pessoas.php">Pessoas</a></li>
				<li class="active"><a href="veiculos.php" >Veiculos</a></li>
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
				<div class="panel-heading">Veiculos Cadastrados</div>
				<div class="navbar navbar-default">
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<button class="btn btn-primary" data-toggle="modal" data-target="#modal-novo">Novo</button>
						</ul>
					</div>
				</div>
				<table class="table table-stripped table-hover" id="table-veiculos">
					<thead>
						<tr>
							<th>Id</th>
							<th>Marca</th>
							<th>Modelo</th>
							<th>Ano de Fabric.</th>
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
					Novo Veículo
				</div>
				<div class="modal-body">
					<form role="form" action="engine.php" method="post">
						<input type="hidden" name="action" value="novo_veiculo" />
						<div class="form-group">
							<label for="marca">Marca</label>
							<input type="text" placeholder="Marca" name="marca" />
						</div>
						<div class="form-group">
							<label for="modelo">Modelo</label>
							<input type="text" placeholder="Modelo" name="modelo" />
						</div>
						<div class="form-group">
							<label for="ano_fabri">Ano fabricação</label>
							<input type="text" placeholder="Ano de Fabricação" name="ano_fabri" />
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
					Novo Veículo
				</div>
				<div class="modal-body">
					<form role="form" action="engine.php" method="post">
						<input type="hidden" name="action" value="atualizar_veiculo" />
						<input type="hidden" name="codigo" id="atualizar_codigo" />
						<div class="form-group">
							<label for="marca">Marca</label>
							<input type="text" placeholder="Marca" name="marca" id="atualizar_marca" />
						</div>
						<div class="form-group">
							<label for="modelo">Modelo</label>
							<input type="text" placeholder="Modelo" name="modelo" id="atualizar_modelo" />
						</div>
						<div class="form-group">
							<label for="ano_fabri">Ano fabricação</label>
							<input type="text" placeholder="Ano de Fabricação" name="ano_fabri" id="atualizar_ano_fabri" />
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
			obterVeiculos();
			preencherCompradores();
			preencherVeiculos();
		});
		function obterVendedorLogado() {
			lib.obterVendedorLogado(function(vendedor) {
				$("#bem-vindo-vendedor").append("<b>"+vendedor.nome+"!</b>");
			});
		}
		function obterVeiculos() {
			lib.obterVeiculos(function(Veiculos) {
				var html = "";
				for (var i=0;i<Veiculos.length;i++) {
					var item = Veiculos[i];
					html += "<tr data-id='"+item.codigo+"'>";
					html += "<td>"+item.codigo+"</td>";	
					html += "<td>"+item.marca+"</td>";	
					html += "<td>"+item.modelo+"</td>";	
					html += "<td>"+item.ano_fabri+"</td>";	
					html += "<td><button type='button' data-toggle='modal' data-target='#modal-update' onclick='prepareUpdate("+JSON.stringify(item)+")' title='Atualizar'><span class='glyphicon glyphicon-retweet'></span></button><button type='button' onclick='deletarVeiculo(\""+item.modelo+"\","+item.ano_fabri+")' title='Deletar'><span class='glyphicon glyphicon-remove-sign'></span></button></td>";	
					html += "</tr>";
				}
				$("#table-veiculos tbody").html(html);
			});
		}

		function deletarVeiculo(nome, ano_fabri) {
			lib.deletarVeiculo(nome, ano_fabri, function() {
				obterVeiculos();
			});	
		}
		
		function preencherCompradores() {
			lib.obterPessoas(function(pessoas) {
				var html="";
				for (var i=0;i<pessoas.length;i++) {
					var pessoa = pessoas[i];
					html += "<option value='"+pessoa.codigo+"'>"+pessoa.nome+"</option>";
				}
				$("#comprador").html(html);
			});	
		}
		function preencherVeiculos() {
			lib.obterVeiculos(function(veiculos) {
				var html="";
				for (var i=0;i<veiculos.length;i++) {
					var veiculo = veiculos[i];
					html += "<option value='"+veiculo.codigo+"'>"+veiculo.marca + " - " + veiculo.modelo +"</option>";
				}
				$("#veiculo").html(html);
			});	
		}
		function prepareUpdate(item) {
			$("#atualizar_codigo").attr("value",item.codigo);
			$("#atualizar_marca").prop("value",item.marca);
			$("#atualizar_modelo").prop("value",item.modelo);
			$("#atualizar_ano_fabri").prop("value",item.ano_fabri);
		}
	</script>
</body>

</html>
