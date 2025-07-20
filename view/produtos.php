<?php
require $_SERVER['DOCUMENT_ROOT'].'/controller/ProdutoController.php';
session_destroy();
$produtoController = new ProdutoController();
$produtos = $produtoController->listaProdutos();
?>

		<div class="container-fluid mt-3">
			<div class="row mt-2">
			  <div class="col-md-12">
			  	<p>Clique abaixo para incluir Novo Produto</p>
				<button onclick="add()" class="btn btn-secondary btn-product">Novo</button>
			  </div>
			</div>
			<div class="row mt-2">
				<div class="col-md-4">
					<h5>Carrinho</h5>
					<p id="mensagem"></p>
					<div><input  type="text" class="form-control" id="email" name="email" style="visibility: hidden;" placeholder="Email"></div>
					<div id="carrinho"></div>
				</div> 
				<div class="col-md-3">
					<p>Consulta CEP</p>
					<input type="text" class="form-control" id="cep">
					<b id="rua"></b>
					<b id="bairro"></b>
					<b id="cidade"></b>
					<b id="uf"></b>
				</div>
			</div>
		    <div class="row">
		    	<div class="col-sm-12">
		    		<div id="conteudo" class="col-sm-12"></div>
					<table class="table caption-top table-borderless">
						<caption>Produtos Disponiveis</caption>
						
		        		<tr> 
			        		<?php 
								$contador = 0;
								foreach ($produtos as $produto) {
								    if ($contador > 0 && $contador % 4 == 0) {
								        echo "</tr><tr>"; 
								    }
								?>
								    <td colspan="2">
								        <img style="width: 120px; height: 150px;" src="public/imagens/<?= $produto['imagem'] ?>">
								        <h5 id="nome" class="text-start nome"><?= $produto['nome'] ?></h5>
								        <p id="preco" value="<?= $produto['preco'] ?>" class="text-start fw-bold preco">R$ <?= str_replace('.', ',', $produto['preco']) ?></p>
								        <p><?= $produto['estoque'] ?></p>
								        <button id="adicionar" class="btn btn-success btn-product add" value="<?= $produto['produto_id'] ?>"  data-id="<?= $produto['produto_id'] ?>" data-nome="<?= $produto['nome'] ?>" data-preco="<?= $produto['preco'] ?>">Comprar</button>
								        <button id="edit" onclick="editar(<?= $produto['produto_id'] ?>)" class="btn btn-primary btn-product" >Editar</button>
								    </td>
								<?php 
								    $contador++;
								}
							?>
						</tr>
					</table>
		        </div>
		        
			</div>
		</div>
<script>

	function editar(id)
	{
		$('#conteudo').load('editProduto/'+id);
	}

     function add()
	{
		$('#conteudo').load('addProduto/');
	} 

	$(document).ready(function () {
  		carregarCarrinho();

		  function carregarCarrinho() {
		    $.post("routes/carrinho.php", { action: "listar" }, function (data) {
		      $('#carrinho').html(data);
		    });
		  }

		  $(document).on("click", "#finalizar", function () {
		  	let email = $('#email').val();
		  	let cep = $('#cep').val();
		  	let soma = $('#soma').text();
		    $.post("routes/carrinho.php", { action: "finalizar", email: email , cep:cep, soma:soma},
		     function (data) {
		       $('#mensagem').text(data);
		    });
		  });

		  $(document).on("click", ".add", function () {
		  	$('#email').css('visibility','');
		    let item = {
		      	action: 'add',
		      	id: $(this).data("id"),
    			nome: $(this).data("nome"),
    			preco: $(this).data("preco")
		    };
		    console.log(item);
		    $.post("routes/carrinho.php", item, function () {
		      carregarCarrinho();
		    });
		  });

		  $(document).on("click", ".remover", function () {
		    let id = $(this).data("id");
		    $.post("routes/carrinho.php", { action: 'remove', id: id }, function () {
		      carregarCarrinho();
		    });
		  });

		   function limpa_formulário_cep() {
				$("#rua").text('');
                $("#bairro").text('');
                $("#cidade").text('');
                $("#uf").text('');
		   }

			$("#cep").blur(function() {

                var cep = $(this).val().replace(/\D/g, '');

                if (cep != "") {

                    var validacep = /^[0-9]{8}$/;

                    if(validacep.test(cep)) {

						limpa_formulário_cep() ;
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                $("#rua").text(dados.logradouro + ',');
                                $("#bairro").text(dados.bairro  + ',');
                                $("#cidade").text(dados.localidade  + ',');
                                $("#uf").text(dados.uf);
                            }
                            else {
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } 
                    else {
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } 
                else {
                    limpa_formulário_cep();
                }
            });
        });

</script>
