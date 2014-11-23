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
				<li class="active"><a href="vendas.php" >Vendas</a></li>
				<li><a href="pessoas.php">Pessoas</a></li>
				<li><a href="veiculos.php">Veiculos</a></li>
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
				<div class="panel-heading">Vendas realizadas</div>
				<div class="navbar navbar-default">
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<button class="btn btn-primary" data-toggle="modal" data-target="#modal-novo">Novo</button>
						</ul>
					</div>
				</div>
				<table class="table table-stripped table-hover" id="table-vendas">
					<thead>
						<tr>
							<th>Comprador</th>
							<th>Marca</th>
							<th>Modelo</th>
							<th>Data</th>
							<th>Modelo</th>
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
						<input type="hidden" name="action" value="nova_venda" />
						<div class="form-group">
							<label for="comprador">Comprador</label>
							<select id="comprador" name="comprador">
							</select>
						</div>
						<div class="form-group">
							<label for="veiculo">Veiculo</label>
							<select id="veiculo" name="veiculo">
							</select>
						</div>
						<div class="form-group">
							<label for="valor">Valor</label>
							<input type="text" placeholder="Valor da Venda" name="valor" />
						</div>
						<button class="btn btn-primary" type="submit">Ok</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" role="dialog" id="modal-atualizar">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" type="button">&times;</button>
					Atualizar Venda
				</div>
				<div class="modal-body">
					<form role="form" action="engine.php" method="post">
						<input type="hidden" name="action" value="atualizar_venda" />
						<input type="hidden" name="codigo" id="atualizar-codigo" />
						<div class="form-group">
							<label for="atualizar-veiculo">Veiculo</label>
							<select id="atualizar-veiculo" name="veiculo" id="atualizar-veiculo-id">
							</select>
						</div>
						<div class="form-group">
							<label for="valor">Valor</label>
							<input type="text" placeholder="Valor da Venda" name="valor" id="atualizar-valor" />
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
			obterVendas();
			preencherCompradores();
			preencherVeiculos();
		});
		function obterVendedorLogado() {
			lib.obterVendedorLogado(function(vendedor) {
				$("#bem-vindo-vendedor").append("<b>"+vendedor.nome+"!</b>");
			});
		}
		function obterVendas() {
			lib.obterVendas(function(vendas) {
				var html = "";
				for (var i=0;i<vendas.length;i++) {
					var item = vendas[i];
					html += "<tr data-id='"+item.codigo+"'>";
					html += "<td>"+item.nome_comprador+"</td>";	
					html += "<td>"+item.marca+"</td>";	
					html += "<td>"+item.modelo+" ("+item.ano_fabri+")"+"</td>";	
					html += "<td>"+lib.parseDate(item.data)+"</td>";
					html += "<td>"+item.valor+"</td>";	
					html += "<td><button class='btn btn-default' type='button' data-toggle='modal' data-target='#modal-atualizar' onclick='atualizarVenda("+JSON.stringify(item)+")' title='Atualizar'><span class='glyphicon glyphicon-retweet'></span></button></td>";	
					html += "</tr>";
				}
				$("#table-vendas tbody").html(html);
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
					html += "<option value='"+veiculo.codigo+"'>"+veiculo.marca + " - " + veiculo.modelo + " ("+ veiculo.ano_fabri +")" +"</option>";
				}
				$("#veiculo,#atualizar-veiculo").html(html);
			});	
		}
		function atualizarVenda(item) {
			$("#atualizar-codigo").attr("value",item.codigo);
			$("#atualizar-veiculo").prop("value",item.cod_veic);
			$("#atualizar-valor").prop("value",item.valor);
		}
	</script>
</body>

</html>
