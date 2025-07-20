<?php
require $_SERVER['DOCUMENT_ROOT'].'/model/Produto.php';

class ProdutoController extends Produto
{
	private $model;

	function __construct() 
	{
		$this->model = new Produto();
	}

	public function adicionaProduto($dados,$imagem) : string
	{
		$mensagem = "Falha no cadastro.";

		$nome = $dados['nome'] ?? null;
		$preco = $dados['preco'] ?: 0;
		$estoque = $dados['estoque'] ?: 1;
		$variacoes = $dados['variacoes'] ?? null;
		$imagemNome = isset($imagem['imagem']['name']) ? $imagem['imagem']['name'] : null;

        $produto = $this->model;
        $cadastrado = $produto->cadastraProduto($nome, $preco, $estoque, $variacoes,$imagemNome);

        if ($cadastrado)
        {
        	if($imagemNome) $this->salvaImagem($imagem);
        	$mensagem = "Sucesso no cadastro.";
        }

        return $mensagem;

	}


	public function editaProduto($dados,$imagem,$id) : string
	{

		$mensagem = "Falha na Edição.";

		if (!$id) return $mensagem;

		$produtoAtual = $this->listaProduto($id);
		$idEstoque = $produtoAtual['estoque_id'];
		$nome = $dados['nome'] ?: $produtoAtual['nome'];
		$preco = $dados['preco'] ?: $produtoAtual['preco'];
		$estoque = $dados['estoque'] ?: $produtoAtual['estoque'];
		$variacoes = $dados['variacoes'] ?: $produtoAtual['variacoes'];
		$imagemNome = $imagem['imagem']['name'] != '' ? $imagem['imagem']['name'] : $produtoAtual['imagem'];

        $produto = $this->model;
        $cadastrado = $produto->atualizaProduto($id,$idEstoque, $nome, $preco, $estoque, $variacoes,$imagemNome);
 		
 		if ($cadastrado)
        {
        	if(isset($imagem['imagem']['name'])) $this->salvaImagem($imagem);
        	$mensagem = "Sucesso na Edição.";
        }

        return $mensagem;

	}

	private function salvaImagem($imagem) : bool
	{
		$pastaDestino = $_SERVER['DOCUMENT_ROOT'].'/public/imagens/';

		 if (!is_dir($pastaDestino)) 
		 {
	        mkdir($pastaDestino, 0755, true);
	    }

	    $nomeTemporario = $imagem['imagem']['tmp_name'];
	    $nomeOriginal = basename($imagem['imagem']['name']);
	    $caminhoDestino = $pastaDestino . $nomeOriginal;


	    if (move_uploaded_file($nomeTemporario, $caminhoDestino)) 
	    {
	    	return true;
		}

		return false;
	}

	public function listaProdutos() : array
	{
		$produtos = $this->model;
		return $produtos->getProdutos();
	}

	public function listaProduto($id) : array 
	{
		$id = isset($id) ? (int) $id : 0;

		$produtos = $this->model;
		return $produtos->getProduto($id);
	}
}

?>