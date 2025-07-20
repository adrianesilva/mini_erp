<?php
class Produto
{
	protected function cadastraProduto($nome, $preco, $estoque, $variacoes,$imagem) : bool
	{
		require $_SERVER['DOCUMENT_ROOT'].'/config/conexao.php';

		if ($mysqli->connect_error) 
		{
		   return false;
		}

		$idEstoque = $this->getMaxId($mysqli, 'estoques');
		
		$stmtE = $mysqli->prepare("INSERT INTO estoques(id, quantidade, variacao) VALUES (?, ?, ?)");

		$stmtE->bind_param("iis", $idEstoque, $estoque, $variacoes);

		$resutadoEstoque = $stmtE->execute();

		$idProduto = $this->getMaxId($mysqli, 'produtos');
		
		$stmtP = $mysqli->prepare("INSERT INTO produtos(id, nome, preco, estoque,imagem) VALUES (?, ?, ?, ?,?)");

		$stmtP->bind_param("issis", $idProduto, $nome, $preco, $idEstoque,$imagem);

		$resutadoProduto = $stmtP->execute();
		
		if ($resutadoEstoque && $resutadoProduto) return true;

		return false;

	}

	protected function atualizaProduto($idProduto,$idEstoque, $nome, $preco, $estoque, $variacoes,$imagem) : bool
	{
		require $_SERVER['DOCUMENT_ROOT'].'/config/conexao.php';

		if ($mysqli->connect_error) 
		{
		   return false;
		}

		$stmtE = $mysqli->prepare("UPDATE estoques SET quantidade = ?, variacao = ? WHERE id = ?");

		$stmtE->bind_param("isi", $estoque, $variacoes, $idEstoque);

		$resutadoEstoque = $stmtE->execute();
		
		$stmtP = $mysqli->prepare("UPDATE produtos SET nome = ?, preco = ?, estoque = ?, imagem = ? WHERE id= ?");

		$stmtP->bind_param("ssisi", $nome, $preco, $idEstoque,$imagem, $idProduto);

		$resutadoProduto = $stmtP->execute();
		
		if ($resutadoEstoque && $resutadoProduto) return true;

		return false;
	}

	private function getMaxId($conexao, $tabela) : int
	{
		$id_qry = $conexao->query("SELECT MAX(id) as id FROM $tabela");
		$max_id = $id_qry->fetch_assoc();
		$id = $max_id['id']+1 ?: 1;

		return $id;
	}

	public function getProdutos() : array
	{
		require $_SERVER['DOCUMENT_ROOT'].'/config/conexao.php';

		$queryProdutos = $mysqli->query("SELECT produtos.id AS produto_id, produtos.nome, produtos.preco,
										produtos.imagem, estoques.quantidade, estoques.variacao AS estoque
								FROM produtos INNER JOIN estoques ON produtos.estoque = estoques.id
								WHERE quantidade>0");

		$produtos = $queryProdutos->fetch_all(MYSQLI_ASSOC) ?: [];

		return $produtos;
	}

	public function getProduto($id) : array
	{
		require $_SERVER['DOCUMENT_ROOT'].'/config/conexao.php';


		$queryProdutos = $mysqli->query("SELECT produtos.id AS produto_id, produtos.nome, produtos.preco,
										produtos.imagem, estoques.quantidade, estoques.variacao AS estoque,
										estoques.id AS estoque_id
										FROM produtos INNER JOIN estoques ON produtos.estoque = estoques.id
										WHERE quantidade>0 AND produtos.id=$id");

		$produtos = $queryProdutos->fetch_assoc() ?: [];

		return $produtos;
	}
}

?>