<?php require_once 'assets/php/respostaFormulario.php';
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
						<form action="responderFormulario.php" method="post">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-3 col-sm-3 col-xs-3">
									</div>
									<div class="col-lg-7 col-sm-7 col-xs-6">
										<h3 for="nomeForm"><?php echo $rowForm->nomeForm ?></h3></br>
									</div>
								</div>
							</div>
							<p></p>
							<div class="row">
								<div class="col-lg-3 col-sm-3 col-xs-3"></div>
								<div class="col-lg-7 col-sm-7 col-xs-6">
									<?php
									$rowP = $perg->index();
									$rowO = $op->index();
									for($j=0; $j<sizeof($rowP); $j++){
										if($rowP[$j]->formularios_idForm == $rowForm->idForm){?>
										<label for="pergunta"><?php echo $rowP[$j]->pergunta ?>:</label></br>
										<?php
										if($rowP[$j]->tipo == 1){ ?>
										<input type="text" name="resposta1[]" maxlength="250"></br></br>
										<?php }elseif($rowP[$j]->tipo == 2){ ?>
										<textarea name="resposta2[]" maxlength="1000"></textarea>
										<?php }if($rowP[$j]->tipo == 3 || $rowP[$j]->tipo == 4){
											for($i=0;$i<sizeof($rowO);$i++){
												if($rowO[$i]->perguntas_idPerg == $rowP[$j]->idPerg){?>
												<?php
												if($rowP[$j]->tipo == 3){ ?>
												<input type="radio" name="resposta3[]" value="<?php echo $rowO[$i]->opcao ?>">
												<?php echo $rowO[$i]->opcao ?>
												<p></p>
												<?php
											}else if($rowP[$j]->tipo == 4){ ?>
											<input type="checkbox" name="resposta4[]" value="<?php echo $rowO[$i]->opcao ?>">
											<?php echo $rowO[$i]->opcao ?>
											<p></p>
											<?php }} ?>
											<?php } ?>
											<?php }?>
											<input type="hidden" name="idPerg[]" value="<?php echo $rowP[$j]->idPerg; ?>">
											<?php }} ?>
											<input type="hidden" name="idForm" value="<?php echo $rowForm->idForm; ?>">
										</div>
									</div>
									<p></p>
									<div class="row">
										<div class="col-lg-3 col-sm-3 col-xs-3"></div>
										<div class="col-lg-2 col-sm-2 col-xs-3">
										</div>
										<div class="col-lg-7 col-sm-7 col-xs-6">
											<input type="hidden" name="contTipo3" value="" id="valorTipo3">
											<input type="hidden" name="contTipo4" value="" id="valorTipo4">
											<button type="submit" name="insert" class="btn btn-primary btn-sm" id="btncadastrar">Enviar</button>
										</div>
									</div>
								</form>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/bootstrap.min.js"></script>
			<script src="assets/js/cadastroPergunta.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
			<script type="text/javascript">
				$(".alert-success").fadeTo(1000, 500).slideUp(300, function(){
					$(".alert-success").alert('close');
				});
				$(".alert-danger").fadeTo(1000, 500).slideUp(300, function(){
					$(".alert-danger").alert('close');
				});
	</script>
</body>
<?php include 'assets/templates/footer.php' ?>
</html>