<?php
require $_SERVER['DOCUMENT_ROOT'].'/model/Pedido.php';

class CarrinhoController extends Pedido
{
	public function adicionarItem() : void
	{
		$id = $_POST['id'];
	  	$nome = $_POST['nome'];
	  	$preco = $_POST['preco'];

	  	if (isset($_SESSION['carrinho'][$id])) {
	    	$_SESSION['carrinho'][$id]['quantidade']++;
	  	} else {
	    	$_SESSION['carrinho'][$id] = [
	      	'nome' => $nome,
	      	'preco' => $preco,
	      	'quantidade' => 1
	    	];
	  	}

	}

	public function removerItem() : void
	{
		$id = $_POST['id'];
  		unset($_SESSION['carrinho'][$id]);
	}

	public function listarItens() : void 
	{
		$carrinho = $_SESSION['carrinho'];
  
		if (empty($carrinho)) {
		    echo "<p>Carrinho vazio.</p>";
		} else 
		{
		    echo "<ul class='list-group '>";
		    $soma = 0;
		    foreach ($carrinho as $id => $item) {
		      $soma = $soma + ($item['preco'] * $item['quantidade']);
		      $preco = str_replace('.',',',$item['preco']);
		      echo "<li class='list-group-item border-0'>
		        {$item['nome']} - R$ {$preco} (x{$item['quantidade']})
		        <button class='remover btn btn-danger' data-id='{$id}'>Remover</button>
		      </li>";
			}
		    echo "<li class='list-group-item border-0' id='soma'>Subtotal: ".str_replace('.',',',$soma). "</li>";
		    echo "<li class='list-group-item border-0'><button id='finalizar' class=' btn btn-success' data-id='{$id}'>Finalizar Pedido</button></li>";
		    echo "</ul>";

		}
	}

	public function incluiPedido() : string
	{

		$carrinho = $_SESSION['carrinho'];
		$dados = $_POST;
		$email = $dados['email'] ?? null;
		$cep = $dados['cep'] ?? null;
		$soma = $dados['soma'] ?? null;

		if (!$soma) {
			return false;
		}

		$soma = str_replace('Subtotal: ','',str_replace(',','.',$soma));

		$frete = $this->verificaFrete($soma);
		$soma = $soma + $frete;

		$pedido = new Pedido();

		if ($pedido->cadastraPedido($carrinho, $email, $cep,$soma)) 
		{
			return 'Pedido realizado.';
			session_destroy();
		}

		return 'Erro';
	}

	private function verificaFrete($soma) : float
	{
		$frete = 20;

		if ($soma >= '52' && $soma <= '166.59') {
			$frete = 15;
		}elseif ($soma > '200') {
			$frete = 0;
		}

		return $frete;

	}
}
?>