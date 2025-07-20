<?php
require 'controller/ProdutoController.php';

?>
<html>
	<head>
		<?php require './config/resources.html'?>
	</head>
	<body>
		<div class="container mt-1 border">
			<h4 id="resposta"></h4><br>
			<h4 class="mb-3">Cadastro de Produto:</h4><hr>
			<form id="form-add" class="needs-validation" method="POST" enctype="multipart/form-data">
				<div class="row g-3 ">
				  <div class="col-md-4 mb-3">
				    <label class="form-label">Nome</label>
				    <input type="text" class="form-control" id="nome" name="nome" required>
				  </div>
				  <div class="col-md-2 mb-3">
				    <label  class="form-label">Preço</label>
				    <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
				  </div>
				  <div class="col-md-4 mb-3">
				    <label  class="form-label">Imagem</label>
				    <input type="file"  class="form-control" id="imagem" name="imagem" required>
				  </div>
				</div>
				<div class="row g-3 form-group">
					<div class="col-md-4 mb-3">
				    <label  class="form-label">Variações</label>
				     <textarea class="form-control" id="variacoes" name="variacoes" required></textarea>
				  </div>
				   <div class="col-md-2 mb-3 ">
				    <label  class="form-label">Estoque</label>
				     <input type="number" class="form-control" id="estoque" name="estoque" required>
				  </div>
				</div> 
				<div class="row g-3 ">
				  <div class="col-12">
				  	<input type="hidden" name="cadastrar" value="true">
				    <button class="btn btn-primary"  type="submit">Cadastrar</button>
				  </div>
				</div>
			</form>
		</div>
		<script>

			$(document).ready(function () {
				$("#form-add").on("submit", function (e) {
			        e.preventDefault();
			        let formData = new FormData(this);

				    $.ajax({
				      url: 'routes/acoes.php',     
				      type: 'POST',
				      data: formData,
				      contentType: false,   
				      processData: false,   
				      success: function (resposta) {
				        $("#resposta").html(resposta);
				      },
				      error: function () {
				        $("#resposta").html("Erro ao enviar.");
				      }
				    });
    			});
			});
		</script>
	</body>
</html>
	