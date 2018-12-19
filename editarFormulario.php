<?php require_once 'assets/php/editaFormulario.php';
include 'assets/templates/header.php';

?>
<body>
	<title>Formulários</title>
	<div id="main" class="container-fluid" >
		<div id="top" class="row" align="center">
			<?php
			if (isset($result)) {
				?>
				<div class="alert alert-success">
					<?php echo $result; ?>
				</div>
				<?php
			}else if(isset($error)){
				?>
				<div class="alert alert-danger">
					<?php echo $error; ?>
				</div>
				<?php
			}
			?>
		</div>
		<div class="table-bordered tableResponder">
			<table class="table">
				<tr>
					<td>
						<form action="editarFormulario.php" method="post" name="formCompleto">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-12 col-sm-12 col-xs-12">
										<h3 class="control-label" for="textinput">Nome do formulário</h3>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 col-sm-12 col-xs-12">
										<input type="name" name="nomeForm"  value="<?php echo $rowForm->nomeForm ?>" maxlength="45">
									</div>
								</div>
							</div>
							<p></p>
							<div class="row">
								<div class="col-lg-12 col-sm-12 col-xs-12">
									<label class="control-label" for="textinput">Perguntas </label>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12 col-sm-12 col-xs-12">
									<?php
									$rowP = $perg->index();
									for($j=0; $j<sizeof($rowP); $j++){
										if($rowP[$j]->formularios_idForm == $rowForm->idForm){ 
											$rowO = $op->indexRelatedTo($rowP[$j]->idPerg);
											?>
											<input type="name" name="pergunta[]" value="<?php echo $rowP[$j]->pergunta ?>" maxlength="1000">
											<!-- <label class="" for="textinput">Tipo  </label> -->
											<?php if($rowP[$j]->tipo == 1){ ?>
											<input type="hidden" name="tipo[]" id="tipo" value="1">
											<input type="text" value="Resposta curta" readonly>
											<?php }elseif($rowP[$j]->tipo == 2){ ?>
											<input type="hidden" name="tipo[]" id="tipo" value="2">
											<input type="text" value="Parágrafo" readonly>
											<?php }elseif($rowP[$j]->tipo == 3){ ?>
											<input type="hidden" name="tipo[]" id="tipo" value="3">
											<input type="text" value="Múltipla escolha" readonly>
											<?php }else{ ?>
											<input type="hidden" name="tipo[]" id="tipo" value="4">
											<input type="text" value="Caixa de seleção" readonly>
											<?php } ?>
											<input type="hidden" name="idPerg[]" value="<?php echo $rowP[$j]->idPerg; ?>">
											<input type="button" class="btn btn-primary" value="x" onclick="removerPergunta(<?php echo $rowForm->idForm; ?>, <?php echo $rowP[$j]->idPerg ?>)">
											<p></p>
											<?php
											if($rowP[$j]->tipo == 3 || $rowP[$j]->tipo == 4){
												for($i=0;$i<sizeof($rowO);$i++){
													if($rowP[$j]->tipo == 3){ ?>
													<input type="radio" name="opcao3[]">
													<input type="name" name="opcao3[]" value="<?php echo $rowO[$i]->opcao ?>" class="contadorTipo3" maxlength="45">
													<input type="button" class="btn btn-primary" value="x" onclick="removerOpcao(<?php echo $rowForm->idForm; ?>, <?php echo $rowP[$j]->idPerg ?>, <?php echo $rowO[$i]->idopcao; ?>, <?php echo $rowP[$j]->tipo; ?>)">
													<input type="hidden" name="idopcao3[]" value="<?php echo $rowO[$i]->idopcao; ?>">
													<p></p>
													<?php }else if($rowP[$j]->tipo == 4){ ?>
													<input type="checkbox" name="opcao4[]">
													<input type="name" name="opcao4[]" value="<?php echo $rowO[$i]->opcao ?>" class="contadorTipo4" maxlength="45">
													<input type="button" class="btn btn-primary" value="x" onclick="removerOpcao(<?php echo $rowForm->idForm; ?>, <?php echo $rowP[$j]->idPerg ?>, <?php echo $rowO[$i]->idopcao; ?>, <?php echo $rowP[$j]->tipo; ?>)">
													<input type="hidden" name="idopcao4[]" value="<?php echo $rowO[$i]->idopcao; ?>">
													<p></p>
													<?php } } ?>
													<div class="radioButton<?php echo $rowP[$j]->idPerg ?>" style="display: none;"></div>
													<div class="checkBox<?php echo $rowP[$j]->idPerg ?>" style="display: none;"></div>
													<input type="button" class="btn btn-primary" onclick="addOpcao(<?php echo $rowForm->idForm ?>, <?php echo $rowP[$j]->idPerg ?>, <?php echo $rowP[$j]->tipo ?>);" value="+">
													<p></p>
													<?php } } } ?>
													<input type="hidden" name="idForm" value="<?php echo $rowForm->idForm; ?>">
												</div>
											</div>
											<p></p>
											<div class="row">
												<div class="col-lg-12 col-sm-12 col-xs-12">
													<p></p>
													<input type="hidden" name="contTipo3" value="" id="valorTipo3">
													<input type="hidden" name="contTipo4" value="" id="valorTipo4">
													<button type="submit" name="edit" class="btn btn-primary btn-sm" id="btncadastrar">Salvar</button>
												</div>
											</div>
										</form>

										<p></p>
										<div class="row">
											<div class="col-lg-12 col-sm-12 col-xs-12">
												<button type="button" class="btn btn-primary btn-sm" id="btncadastrar" onclick="insertPerg();">Adicionar Pergunta</button>
												<div id="pergOculta" style="display: none">
													<form  method="post" action="editarFormulario.php" class="pergunta" id='pergunta'>
														<label>Pergunta</label>
														<input type="textinput" name="pergunta" class="form-control input-md" placeholder="Pergunta" required>
														<p></p>
														<label for="tipo">Tipo da pergunta</label>
														<select name="tipo" class="tipo form-control input-md">
															<option value="0">Selecione o tipo</option>
															<option value="1">Resposta curta</option>
															<option value="2">Parágrafo</option>
															<option value="3">Múltipla escolha</option>
															<option value="4">Caixa de seleção</option>
														</select>
														<input type="hidden" name="idForm" value="<?php echo $rowForm->idForm; ?>">
														<input type="hidden" name="nomeForm" value="<?php echo $rowForm->nomeForm; ?>">
														<p></p>
														<div class="optionOculto">
															<input type="button" class="btn btn-primary" id="add" value="+">
															<input type="button" class="btn btn-primary" id="remove" value="-">
														</div>
														<p></p>
														<button type="submit" name="insert" class="btn btn-primary btn-sm" id="btncadastrar">Cadastrar</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<script src="assets/js/jquery.min.js"></script>
				<script src="assets/js/bootstrap.min.js"></script>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
				<script type="text/javascript">
					$(".alert-success").fadeTo(1000, 500).slideUp(300, function(){
						$(".alert-success").alert('close');
					});
					$(".alert-danger").fadeTo(1000, 500).slideUp(300, function(){
						$(".alert-danger").alert('close');
					});

	  contTipo3 = $('.contadorTipo3').length;//conta quantos radio buttons existe em cada pergunta
	  contTipo4 = $('.contadorTipo4').length;//conta quantos checkboxes existe em cada pergunta
	  document.getElementById('valorTipo3').value = contTipo3;//passa o valor para o formulario
	  document.getElementById('valorTipo4').value = contTipo4;

	  function removerOpcao(idForm, idPerg, idopcao, tipo){
	  	if(tipo == 3){
	  		if(contTipo3 == 1){
	  			alert('A pergunta ficará sem opções para a resposta');
	  		}else{
	  			window.location.href = "assets/php/editaFormulario.php?idForm="+idForm+"&idPerg="+idPerg+"&idopcao"+idopcao+"&deleteOp="+idopcao;
	  		}
	  	}else if(tipo == 4){
	  		if(contTipo4 == 1){
	  			alert('A pergunta ficará sem opções para a resposta');
	  		}else{
	  			window.location.href = "assets/php/editaFormulario.php?idForm="+idForm+"&idPerg="+idPerg+"&idopcao"+idopcao+"&deleteOp="+idopcao;
	  		}
	  	}
	  }

	  function removerPergunta(idForm, idPerg){
	  	window.location.href = "assets/php/editaFormulario.php?idForm="+idForm+"&idPerg="+idPerg+"&deletePerg="+idPerg;
	  }

	  function addOpcao(idForm, idPerg, tipo){
	  	if(tipo == 3){
	  		$('.radioButton'+idPerg).show();
	  		var div = $('.radioButton'+idPerg);
	  		div.html('');
	  		var nomeOpcao = '<input type="radio" name="opcao">';
	  		div.append(nomeOpcao);
	  		var frase = '<input type="name" name="opcao" id="opcao" class="contadorTipo3" maxlength="45">';
	  		div.append(frase);
	  		var apagar = '<input type="button" class="btn btn-primary" value="x">';
	  		div.append(apagar); 
	  	}else if(tipo == 4){
	  		$('.checkBox'+idPerg).show();
	  		var div = $('.checkBox'+idPerg);
	  		div.html('');
	  		var nomeOpcao = '<input type="checkbox" name="opcao">';
	  		div.append(nomeOpcao);
	  		var frase = '<input type="name" name="opcao" id="opcao" class="contadorTipo4" maxlength="45">';
	  		div.append(frase);
	  		var apagar = '<input type="button" class="btn btn-primary" value="x">';
	  		div.append(apagar);
	  	}
	  	window.location.href = "assets/php/editaFormulario.php?idForm="+idForm+"&idPerg="+idPerg+"&insertOp="+opcao;
	  	/*if($('#opcao').val() != ''){
	  		window.location.href = "assets/php/editaFormulario.php?idForm="+idForm+"&idPerg="+idPerg+"&insertOp="+opcao;
	  	}*/
	  }

	  function insertPerg(){
	  	$('#pergOculta').show();
	  }

	  $(document).ready(function() {
	  	$('.optionOculto').hide();
	  	$('.tipo').change(function() {
	  		var div = $('.optionOculto');
	  		if ($('.tipo').val() == 3) {
	  			$('.optionOculto').show();
	  			var value = 1;
	  			var nomeOpcao = '<input type="text" name="opcoes[]' + value +'" class="form-control formopcoes" id="input' + value + '" placeholder="Insira as opções aqui" maxlength="45" required></div>';
	  			var frase = '<div class="respDivs" id="resp' + value + '"><input id="radio' + value + '" type="radio" name="teste" value="' + value +'"> '+ nomeOpcao;
	  			div.append(frase);
	  			value++;
	  		}else if ($('.tipo').val() == 4){ 
	  			$('.optionOculto').show();
	  			var value = 1;
	  			var nomeOpcao = '<input type="text" name="opcoes[]' + value +'" class="form-control formopcoes" id="input' + value + '" placeholder="Insira as opções aqui" maxlength="45" required> </div>';
	  			var frase = '<div class="respDivs" id="resp' + value + '"><input id="checkbox' + value + '" type="checkbox" value="' + value + '"> '+ nomeOpcao;
	  			div.append(frase);
	  			value++;
	  		}else {
	  			$('.optionOculto').hide();
	  		}
	  	});

	  	var value = 2;
	  	$('#add').click(function(e){
	  		e.preventDefault();
	  		e.stopPropagation();
	  		var div = $('.optionOculto');
	  		if($('.tipo').val() == '3'){
	  			var nomeOpcao = '<input type="text" name="opcoes[]' + value +'" class="form-control formopcoes" id="input' + value + '" maxlength="45" placeholder="Insira as opções aqui" required> </div>';
	  			var frase = '<div class="respDivs" id="resp' + value + '"><input id="radio' + value + '" type="radio" value="' + value +'"> '+ nomeOpcao;
	  			div.append(frase);
	  			value++;
	  		} else if($('.tipo').val() == '4'){
	  			var nomeOpcao = '<input type="text" name="opcoes[]' + value +'" class="form-control formopcoes" id="input' + value + '" placeholder="Insira as opções aqui" maxlength="45" required> </div>';
	  			var frase = '<div class="respDivs" id="resp' + value + '"><input id="checkbox' + value + '" type="checkbox" value="' + value + '"> '+ nomeOpcao;
	  			div.append(frase);
	  			value++;
	  		}
	  	});
	  	$('#remove').click(function(e) { 
	  		value--;
	  		if(value == 1){
	  			alert("Selecione uma opção");
	  			return;
	  		}
	  		
	  		if($('.tipo').val() == '3' || $('.tipo').val() == '4'){
	  			$("#resp" + value).remove();
	  		}
	  	});
	  });
	</script>
</body>
<?php include 'assets/templates/footer.php' ?>
</html>