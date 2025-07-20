<?php
require $_SERVER['DOCUMENT_ROOT'].'/controller/ProdutoController.php';

$produtoController = new ProdutoController();
$retorno = '';

if (isset($_POST['editar'])) 
{
	$retorno = $produtoController->editaProduto($_POST,$_FILES,$_POST['id']);
	echo $retorno;
}

if (isset($_POST['cadastrar'])) {

	$produto = new ProdutoController();
	$retorno = $produto->adicionaProduto($_POST,$_FILES);
}
?>