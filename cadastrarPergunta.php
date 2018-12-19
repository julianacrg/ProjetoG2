
<?php require_once 'assets/php/cadastroPergunta.php'; 
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
		<form method="post" action="cadastrarPergunta.php">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Pergunta</label>
					<input type="text" name="pergunta" class="form-control input-md" placeholder="Pergunta" maxlength="1000" required>
					<p></p>

					<label for="tipo">Tipo da pergunta</label>
					<select required id="tipo" name="tipo" class="form-control input-md">
						<option value="">Selecione o tipo</option>
						<option value="1">Resposta curta</option>
						<option value="2">Parágrafo</option>
						<option value="3">Múltipla escolha</option>
						<option value="4">Caixa de seleção</option>
					</select>

					<p></p>
					<input type="hidden" name="idForm" value="<?php echo $idForm ?>">
					<button type="submit" class="btn btn-primary" name="insertP">Cadastrar</button>
					<p></p>
					<div id="inputOculto">
						<input type="button" class="btn btn-primary" id="add" value="+">
						<input type="button" class="btn btn-primary" id="remove" value="-">
					</div>
					<div id="divisao-form"></div>
				</div>
			</div>
			<div class="col-md-4"></div>
		</form>
	</div>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/cadastroPergunta.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</body>
<?php include 'assets/templates/footer.php';?>

</html>