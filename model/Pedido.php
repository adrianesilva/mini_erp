<?php
class Pedido
{
	protected function cadastraPedido($carrinho, $email, $cep, $soma) : bool
	{
		require $_SERVER['DOCUMENT_ROOT'].'/config/conexao.php';

		if ($mysqli->connect_error) 
		{
		   return false;
		}
		$idPedido = $this->getMaxId($mysqli, 'pedidos');

		$stmt = $mysqli->prepare("INSERT INTO pedidos(id, descricao_pedido, valor_total, cep, email, status) VALUES (?, ?, ?, ?, ?, ?)");


		$carrinho = json_encode($carrinho);
		$status = 1;

		$stmt->bind_param("issssi", $idPedido, $carrinho, $soma, $cep, $email, $status);

		$resutado = $stmt->execute();

		if ($resutado) return true;

		return false;
	}

	private function getMaxId($conexao, $tabela) : int
	{
		$id_qry = $conexao->query("SELECT MAX(id) as id FROM $tabela");
		$max_id = $id_qry->fetch_assoc();
		$id = $max_id['id']+1 ?: 1;

		return $id;
	}

	
}

?>