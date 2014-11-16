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
		$query = "select v.codigo as codigo, p.nome as nome_comprador, veic.marca as marca, veic.modelo as modelo, v.data_vend as data, v.vlr_venda as valor from venda v inner join vendedor ve on ve.codigo=v.cod_vend inner join veiculo veic on veic.codigo=v.cod_veic inner join pessoa p on p.codigo=v.cod_pess where cod_vend=" . $id_vendedor;
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
		$comprador = $_POST['comprador'];
		$veiculo = $_POST['veiculo'];
		$valor = $_POST['valor'];
		$query = "insert into venda (cod_pess,cod_veic,cod_vend,data_vend,vlr_venda) values (" . $comprador . ", " . $veiculo . ", " . $id_vendedor . ", now(), " . $valor . ")";
		$res = mysql_query($query,$con);
		if (!$res) {
			header("location: vendas.php?ok=false&msg=".mysql_error());
		} else {
			header("location: vendas.php?ok=true");
		}
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
?>
