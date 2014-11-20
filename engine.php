<?php

require_once('verify_session.php');

require_once('conexao.php');


$action = $_POST['action'];

switch ($action) {
	case "vendedor_logado":
		$id_vendedor = $_SESSION['id_vendedor'];
		$query = "select * from vendedor where codigo=" . $id_vendedor;
		return_query($query,$con);
		break;
	case "vendas_logado":
		$id_vendedor = $_SESSION['id_vendedor'];
		$query = "select v.codigo as codigo, p.nome as nome_comprador, cod_veic, cod_pess, veic.marca as marca, veic.modelo as modelo, veic.ano_fabri as ano_fabri, v.data_vend as data, v.vlr_venda as valor from venda v inner join vendedor ve on ve.codigo=v.cod_vend inner join veiculo veic on veic.codigo=v.cod_veic inner join pessoa p on p.codigo=v.cod_pess where cod_vend=" . $id_vendedor;
		return_query_array($query,$con);
		break;
	case "obter_pessoas":
		$query = "select * from pessoa";
		return_query_array($query,$con);
		break;
	case "obter_veiculos":
		$query = "select * from veiculo";
		return_query_array($query,$con);
		break;
	case "nova_venda":
		$id_vendedor = $_SESSION['id_vendedor'];
		$comprador = mysql_escape_string($_POST['comprador']);
		$veiculo = mysql_escape_string($_POST['veiculo']);
		$valor = mysql_escape_string($_POST['valor']);
		$query = "insert into venda (cod_pess,cod_veic,cod_vend,data_vend,vlr_venda) values (" . $comprador . ", " . $veiculo . ", " . $id_vendedor . ", now(), " . $valor . ")";
		realiza_DML($query,$con,"vendas.php","Venda adicionada com sucesso!");
		break;
	case "atualizar_venda":
		$id_venda = mysql_escape_string($_POST['codigo']);
		$id_veic = mysql_escape_string($_POST['veiculo']);
		$valor = mysql_escape_string($_POST['valor']);
		$query = "update venda set cod_veic=" . $id_veic . ", vlr_venda=" . $valor . " where codigo=" . $id_venda;
		realiza_DML($query,$con,"vendas.php","Venda atualizada com sucesso!");
		break;
	case "obter_usuarios":
		$id_vendedor = $_SESSION['id_vendedor'];
		$query = "select * from usuario where id_vendedor=" . $id_vendedor;
		return_query_array($query,$con);
		break;
	case "novo_usuario":
		$id_vendedor = $_SESSION['id_vendedor'];
		$nome_usuario = mysql_escape_string($_POST['nome']);
		$password = $_POST['password'];
		$passsha1 = sha1($password);

		$query_buscar = "select * from usuario where nome_usuario='" . $nome_usuario . "'";
		$res = mysql_query($query_buscar,$con);
		if (mysql_num_rows($res) > 0) {
			header('location: usuarios.php?error=true&msg=Usuario ja existe na base de dados');
			die("Usuário já cadastrado");
		}

		$query = "insert into usuario (nome_usuario, senha, id_vendedor) values ('" . $nome_usuario . "', '". $passsha1 . "', " . $id_vendedor . ")";
		realiza_DML($query,$con,"usuarios.php","Usuario adicionado com sucesso!");
		break;
	case "deletar_usuario":
		$nome_usuario = mysql_escape_string($_POST['nome_usuario']);
		$query = "delete from usuario where nome_usuario='" . $nome_usuario . "'";
		realiza_DML($query,$con,"usuarios.php","Usuario apagado com sucesso!");
		break;
	case "novo_veiculo":
		$id_vendedor = $_SESSION['id_vendedor'];
		$marca = mysql_escape_string($_POST['marca']);
		$modelo = mysql_escape_string($_POST['modelo']);
		$ano_fabri = mysql_escape_string($_POST['ano_fabri']);

		$query_buscar = "select * from veiculo where modelo='" . $modelo . "' and ano_fabri=" . $ano_fabri;
		$res = mysql_query($query_buscar,$con);
		if (mysql_num_rows($res) > 0) {
			header('location: veiculos.php?error=true&msg=Modelo ja existe na base de dados');
			die("Modelo já cadastrado");
		}

		$query = "insert into veiculo (marca, modelo, ano_fabri) values ('" . $marca . "', '". $modelo . "', " . $ano_fabri . ")";
		realiza_DML($query,$con,"veiculos.php","Veiculo adicionado com sucesso!");
		break;
	case "atualizar_veiculo":
		$id_vendedor = $_SESSION['id_vendedor'];
		$codigo = mysql_escape_string($_POST['codigo']);
		$marca = mysql_escape_string($_POST['marca']);
		$modelo = mysql_escape_string($_POST['modelo']);
		$ano_fabri = mysql_escape_string($_POST['ano_fabri']);
		$query_buscar = "select * from veiculo where modelo='" . $modelo . "' and ano_fabri=" . $ano_fabri;
		$res = mysql_query($query_buscar,$con);
		if (mysql_num_rows($res) > 0) {
			header('location: veiculos.php?error=true&msg=Modelo ja existe na base de dados');
			die("Modelo já cadastrado");
		}
		$query = "update veiculo set marca='" . $marca . "', modelo='" . $modelo . "', ano_fabri=" . $ano_fabri  . " where codigo=" . $codigo ;
		realiza_DML($query,$con,"veiculos.php","Veiculo atualizado com sucesso!");
		break;
	case "deletar_veiculo":
		$modelo = mysql_escape_string($_POST['modelo']);
		$ano_fabri = mysql_escape_string($_POST['ano_fabri']);
		$query = "delete from veiculo where modelo='" . $modelo . "' and ano_fabri=".$ano_fabri;
		realiza_DML($query,$con,"veiculos.php","Veiculo apagado com sucesso!");
		break;

}

function return_query($q, $con) {
	$res = mysql_query($q,$con);
	if (mysql_num_rows($res) > 0) {
		$result = json_encode(mysql_fetch_assoc($res));
		header("content-type: application/json");
		echo $result;
	}
}

function return_query_array($q, $con) {
	$res = mysql_query($q,$con);
	if (!$res) {
		echo mysql_error();
	} else {
		if (mysql_num_rows($res) > 0) {
			$result = array();
			while ($row = mysql_fetch_assoc($res)) {
				array_push($result, $row);
			}
			header("content-type: application/json");
			echo json_encode($result);
		} else {
			echo "no records";
		}
	}
}

function realiza_DML($q,$con,$page,$successMsg) {
	$res = mysql_query($q,$con);
	if (!$res) {
		header("location: " . $page . "?error=true&msg=".mysql_error());
	} else {
		header("location: " . $page . "?error=falsei&msg=".$successMsg);
	}
}
?>
