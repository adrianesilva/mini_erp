<html>
	<head>
		<?php require './config/resources.html'?>
		<title>Mini ERP</title>
	</head>
	<body>
		<?php require 'navbar.php' ?>
		<div class="container-fluid mt-5">
			<h4 class="text-center">Cadastro, Estoque e Compra de Produtos.</h4>
		</div>
		<?php session_start(); require 'produtos.php'; ?>
	</body>
</html>