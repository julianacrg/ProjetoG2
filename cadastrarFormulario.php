<?php
require_once 'assets/php/cadastroFormulario.php';
require_once 'assets/php/classes/classFormulario.php';
include 'assets/templates/header.php';

use JasonGrimes\Paginator;
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
			<div class="col-sm-5 col-sm-offset-3">
				<div class="col-sm-3">
					<href="#" data-toggle="modal" data-target="#cadastrar-modal" class="btn h2" id="btnresponsivo">Cadastrar</a>
				</div>
				<!-- Pesquisa -->
				<form method="get" action="cadastrarFormulario.php">
					<div class="input-group h2">
						<input name="nome" class="form-control" id="nome" type="text" placeholder="Pesquisar formulários">
						<span class="input-group-btn">
							<button class="btn btn-primary" id="pesquisar" type="submit" name="submit">
								<span class="glyphicon glyphicon-search"></span>
							</button>
							<button class="btn btn-primary" type="button" id="limpar" onclick="limpa('cadastrarFormulario.php');" title="Limpar pesquisa">
								<span class="glyphicon glyphicon-erase"></span>
							</button>
						</span>
					</div>
				</form>
			</div>
		</div><!-- /#top -->
		<hr />
		<div id="list" class="row">
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
						for($i=0;$i<sizeof($queryResult);$i++){
							?>
							<tr>
								
									<td>
										<?php echo $queryResult[$i]->nomeForm ?></a>
									</td>
								</form>
								<td>
									
								<form method="post" action="responderFormulario.php">
									<input type="hidden" name="idForm" value="<?php echo $queryResult[$i]->idForm;?>">
									<button class="btn btn-sm" id="btncadastrar" type="submit" name="submit">Responder</button>	
								</form>

								<form method="post" action="editarFormulario.php">
									
										<input type="hidden" name="idForm" value="<?php echo $queryResult[$i]->idForm;?>">
										<button class="btn btn-sm" id="btncadastrar" type="submit" name="submit">Editar</button>
									</form>
									<button class="btn btn-sm" id="btncadastrar" data-toggle="modal" data-target="#delete<?php echo $queryResult[$i]->idForm ?> " id="deleteModal">Excluir</button>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<?php echo $paginator->toHtml(); ?>
								<!-- /.pagination -->
							</div>
							<div class="col-md-4"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal Cadastrar -->
			<div class="modal fade" id="cadastrar-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
				<div class="modal-dialog" modal-lg role="document">
					<div class="modal-content">
						<div class="modal-header" >
							<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" ><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="modalLabel">Cadastro de Formulário</h4>
						</div>
						<div class="modal-body">
							<form method="post" action="cadastrarPergunta.php" class="formularios" id="formularios">
								<div id="pf">
									<div class="form-group">
										<label class="col-md-4 control-label" for="textinput">Nome do formulário</label>
										<div class="col-md-8">
											<input type="text" name="nome" class="form-control input-md" required maxlength="45">
											<p></p>
										</div>
									</div>
								</div>
								<div id="pf">
									<div class="form-group">
										<div id="botao" align="center">
											<br><button type="submit" name="insert" class="btn btn-success btn-sm">Cadastrar</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal Excluir-->
			<?php
			for($i=0; $i<sizeof($queryResult); $i++){
				?>
				<div class="modal fade" id="delete<?php echo $queryResult[$i]->id ;?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="modalLabel">Excluir Formulário</h4>
							</div>
							<form action="cadastrarFormulario.php" method="post">
								<div class="modal-body">
									Deseja realmente excluir o formulario? <?php echo $queryResult[$i]->form;?>?
								</div>
								<div class="modal-footer">
									<button type="submit" name="delete" class="btn" id="btncadastrar">Sim</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
									<input type="hidden" name="id" value="<?php echo $queryResult[$i]->id; ?>">
								</div>
							</form>	
						</div>
					</div>
				</div>
				<?php
			}
			?>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/bootstrap.min.js"></script>
			<script src="assets/js/funcoes.js"></script>
			<script src="assets/vendor/multiselect/js/jquery.multi-select.js" type="text/javascript"></script>		
		</body>
		<?php include 'assets/templates/footer.php' ?>
		</html>
