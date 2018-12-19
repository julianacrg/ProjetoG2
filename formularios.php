<?php 
		require_once 'assets/php/constants.php';
		$acesso = __ACESSO_FUNCIONARIO__;
		require_once 'assets/php/protection.php';
	?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/multi-select/css/multi-select.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
	<link rel="shortcut icon" href="assets/images/favicon.png"/> 
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/main.css" rel="stylesheet">
	<title>Área do Funcionário</title>
	</head>
	<body>
		<div class="container">
			<a href="sistema.php"><img class="img-responsive" id="imgcabecalho" href="sistema.php" src="assets/images/Gerdau-logo.png" />	</a>
		</div>
		<nav class="nav" id="menu">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false" aria-controls="navbar" id="toggleButton">
			    <span class="icon-bar"></span>
			    <span class="icon-bar"></span>
			    <span class="icon-bar"></span>                        
			  </button>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="sistemaFuncionario.php">Home</a></li>
					<li class="active"><a href="formularios.php">Formulários</a></li>
					<li><?php echo '<a href="assets/php/logout.php">Sair</a>'; ?></li>
				</ul>
			</div>
		</nav>
		<!-- Pesquisa de Formulario -->
		<div class="linhaCadastro">
			<!-- Pesquisa -->
			<form method="get" action="formularios.php" class="form-inline">
				<div class="form-group">
					<input name="nome" class="form-control" id="nome" type="text" placeholder="Pesquisar Formulários">
					<button class="btn btnGerdau " id="pesquisar" type="submit" name="submit">
					<span class="glyphicon glyphicon-search"></span>
					</button>
					<button class="btn btnGerdau type="submit" id="limpar" type="submit" onclick="limpa('formularios.php');" title="Limpar pesquisa">
					<span class="glyphicon glyphicon-erase"></span>
					</button>
				</div>
			</form>
		</div>
			<!-- Dados dos Formulários Cadastrados -->
			<div id="list" class="row noMargin">
				<div class="table-responsive col-md-12">
					<table class="table table-striped" cellspacing="0" cellpadding="0">
						<thead>
							<tr id="tr">
								<th>Nome do Formulário</th>
								<th class="actions">Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php
							for($i = 0; $i < sizeof($queryResult); $i++){
								?>
								<tr>
									<td>
										<?php echo $queryResult[$i]->nomeForm ?>
									</td>
									<td class="alinhaBotoes">
										<form method="post" action="responderFormulario.php">
											<input type="hidden" name="idForm" value="<?php echo $queryResult[$i]->idForm;?>">
											<button class="btn btn-sm btnGerdau" type="submit" name="submit">Responder</button>
										</form>

										<form method="post" action="editarFormulario.php">
											<input type="hidden" name="idForm" value="<?php echo $queryResult[$i]->idForm;?>">
											<button class="btn btn-sm btnGerdau" type="submit" name="submit">Editar</button>
										</form>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<!-- Paginação -->
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<?php echo $paginator->toHtml(); ?>
							</div>
							<div class="col-md-4"></div>
						</div>
					</div>
				</div>
			</div>
