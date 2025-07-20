<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/controller/CarrinhoController.php';

$carrinhoController = new CarrinhoController();

if (!isset($_SESSION['carrinho'])) {
  $_SESSION['carrinho'] = [];
}

if ($_POST['action'] == 'add') {
  
  $carrinhoController->adicionarItem();

}

if ($_POST['action'] == 'remove') {
   $carrinhoController->removerItem();
}

if ($_POST['action'] == 'listar') {
  $carrinhoController->listarItens();
}

if ($_POST['action'] == 'finalizar') {
  echo $carrinhoController->incluiPedido();
}