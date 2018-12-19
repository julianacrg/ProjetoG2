<?php
require_once 'assets/php/cadastroFuncionario.php';
include 'assets/templates/header.php';
use JasonGrimes\Paginator;
?>
<body>
	<title>Funcionários</title>
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
		</br>
		<div class="container">
			<div class="col-md-2"></div>
			<div class="col-md-2" style="margin-top: 5px">
				<a data-toggle="modal" data-target="#cadastrar-modal" class="btn" id="btncadastrar">Cadastrar</a>
			</div>
			<div class="col-md-3">
				<!-- Pesquisa -->
				<form action="cadastrarFuncionario.php" method="get">
					<input name="nome" class="form-control" id="nome" type="text" placeholder="Pesquisar funcionários"  style="margin-top: 5px"></div>
					<div class="col-md-2">
						<select class="form-control" id="status" name="status"  style="margin-top: 5px">
							<option value="">Status</option>
							<option value="1">Ativo</option>
							<option value="0">Inativo</option>
						</select>
					</div>
					<div class="col-md-2"  style="margin-top: 5px">
						<button class="btn " id="pesquisar" type="submit" name="submit">
							<span class="glyphicon glyphicon-search"></span>
						</button>
						<button class="btn " type="submit" id="limpar" onclick="limpa('cadastrarFuncionario.php');" title="Limpar pesquisa">
							<span class="glyphicon glyphicon-erase"></span>
						</button>
						<div class="col-md-1"></div>
					</div>
				</form>
				<hr>
				<!-- /#top -->
				<div id="list" class="row">
					<div class="table-responsive col-md-12">
						<table class="table table-striped" cellspacing="0" cellpadding="0">
							<thead>
								<tr id="tr">
									<th>Nome</th>
									<th>Foto</th>
									<th>Número Pessoal</th>
									<th>ASO</th>
									<th>Cargo</th>
									<th>Status</th>
									<th>Célula</th>
									<th class="actions">Ações</th>
								</tr>
							</thead>
							<tbody>
								<?php for($i=0;$i<sizeof($queryResult);$i++){ ?>
								<tr>
									<form action="cadastrarFuncionario.php" method="post">
										<td><?php echo $queryResult[$i]->nome ?></td>
										<td><img src="<?php echo $queryResult[$i]->foto ?>" class="imagem"></td>
										<td><?php echo $queryResult[$i]->numero ?></td>
										<td><?php echo date("d/m/Y", strtotime($queryResult[$i]->aso)) ?></td>
										<td><?php echo $queryResult[$i]->cargo ?></td>
										<td><?php if($queryResult[$i]->status == 1) { ?>Ativo
											<?php }else{ ?>Inativo
											<?php } ?>
										</td>
										<?php
										$stmtCelula = $celula->index();
										while ($rowCelula = $stmtCelula->fetch(PDO::FETCH_OBJ)) {
											if ($rowCelula->id == $queryResult[$i]->celulas_id) {
												?>
												<td><?php echo $rowCelula->nome; ?></td>
												<?php
											}
										}
										?>
										<td>
											<input type="hidden" name="idFunc" value="<?php echo $queryResult[$i]->idFunc ?>">
											<button type="button" class="btn btn-sm" data-toggle="modal" id="btncadastrar"  data-target="#edit<?php echo $queryResult[$i]->idFunc ?>" id="editModal">
											Editar</button>
										</td>
									</form>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<div class="container-fluid text-center">
							<div class="row">
								<div class="col-md-4"></div>
								<div class="col-md-4">
									<?php echo $paginator->toHtml(); ?>
									<!-- /.pagination -->
								</div>
								<div class="col-md-4"></div>
							</div>
						</div>
						<!-- /#bottom -->
					</div>
				</div>
			</div>
			<!-- /#main -->
			<!-- Modal Cadastrar-->
			<div class="modal fade" id="cadastrar-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
				<div class="modal-dialog" modal-lg role="document">
					<div class="modal-content">
						<div class="modal-header" >
							<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" ><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="modalLabel">Dados Cadastrais</h4>
						</div>
						<div class="modal-body">
							<form  method="post" action="cadastrarFuncionario.php" class="funcionarios" id='funcionarios' enctype="multipart/form-data">
								<!-- Text input-->
								<div id="pf">
									<div class="form-group">
										<label class="col-md-4 control-label" for="textinput">Nome</label>
										<div class="col-md-8">
											<input id="nome" name="nome" type="text" placeholder="Ex: José Da Silva"
											class="form-control input-md" required>
											<p></p>
										</div>
									</div>
								</div>
								<div id="pf">
									<div class="form-group">
										<label class="col-md-4 control-label" for="textinput">Email</label>
										<div class="col-md-8">
											<input id="email" name="email" type="email" placeholder="Ex: jose@email.com"
											class="form-control input-md" required>
											<p></p>
										</div>
									</div>
								</div>
								<!-- File input-->
								<div id="pf">
									<div class="form-group">
										<label class="col-md-4 control-label" for="textinput">Foto</label>
										<div class="col-md-8">
											<input id="foto" name="foto" type="file">
											<p></p>
										</div>
									</div>
								</div>
								<!-- Text input-->
								<div id="pf">
									<div class="form-group">
										<label class="col-md-4 control-label" for="textinput">Número pessoal</label>
										<div class="col-md-8">
											<input id="numero" name="numero" type="text" class="form-control input-md" size="8" maxlength="8" required>
											<p></p>
										</div>
									</div>
								</div>
								<!-- Multiple Radios (inline) -->
								<div id="pf">
									<div class="form-group">
										<label class="col-md-4 control-label" for="textinput">ASO</label>
										<div class="col-md-8">
											<input type="date" name="aso" class="form-control input-md" required>
											<p></p>
										</div>
									</div>
								</div>
								<div id="pf">
									<div class="form-group">
										<label class="col-md-4 control-label" for="textinput">Cargo</label>
										<div class="col-md-8">
											<input id="cargo" name="cargo" type="text" placeholder="Ex: Gerente"
											class="form-control input-md" required>
											<p></p>
										</div>
									</div>
								</div>
								<div id="pf">
									<div class="form-group">
										<label class="col-md-4 control-label" for="textinput">Status</label>
										<div class="col-md-8">
											<input type="radio" name="status" value="1">Ativo
											<input type="radio" name="status" value="0">Inativo
											<p></p>
										</div>
									</div>
								</div>
								<div id="pf">
									<div class="form-group">
										<label class="col-md-4 control-label" for="textinput">Nome da célula</label>
										<div class="col-md-8">
											<select id="select" name="celulas_id" class="form-control" action="cadastrarArea.php" required>
												<option value=""> Selecione</option>
												<?php
												$stmt = $celula->index();
												while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
													?>
													<option id="<?php echo $row->id; ?>" value="<?php echo $row->id; ?>"> <?php echo $row->nome; ?>
													</option>
													<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div id="pf">
									<div class="form-group">
										<div id="botao" align="center">
											<input type="hidden" name="action" value="insert">
											<br><button type="submit" value="Cadastrar" class="btn btn-sm" id="btncadastrar">Enviar</button><br>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php
			for($i=0; $i<sizeof($queryResult); $i++){
				?>
				<!-- MODAL QUE EDITA O FUNCIONARIO -->
				<div class="modal fade" id="edit<?php echo $queryResult[$i]->idFunc ?>" role="dialog">
					<div class="modal-dialog" modal-lg role="document">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Editar Funcionário</h4>
							</div>
							<div class="modal-body">
								<form action="cadastrarFuncionario.php" method="post" class="funcionarios" id='funcionarios' enctype="multipart/form-data">
									<div id="pf">
										<div class="form-group">
											<label class="col-md-4 control-label" for="textinput">Nome</label>
											<div class="col-md-8">
												<input type="text" name="nome" id="nome" class="form-control input-md" value="<?php echo $queryResult[$i]->nome ?>" required>
												<p></p>
											</div>
										</div>
									</div>
									<div id="pf">
										<div class="form-group">
											<label class="col-md-4 control-label" for="textinput">E-mail</label>
											<div class="col-md-8">
												<?php 
												$login = new Login();
												$stmt = $login->getIdFuncionario($queryResult[$i]->idFunc);
												if(!empty($stmt)){
													if($stmt->funcionario_id == $queryResult[$i]->idFunc){
														?>
														<input type="email" name="email" id="email" class="form-control input-md" value="<?php echo $stmt->email ?>" readonly>
														<p></p>
														<?php } }else{ ?>
														<input type="email" name="email" id="email" class="form-control input-md">
														<p></p>
														<?php } ?>
													</div>
												</div>
											</div>
											<div id="pf">
												<div class="form-group">
													<label class="col-md-4 control-label" for="textinput">Foto</label>
													<div class="col-md-8">
														<img src="<?php echo $queryResult[$i]->foto ?>" class="imagem">
														<input type="hidden" name="fotoatual" id="foto" value="<?php echo $queryResult[$i]->foto; ?>">
														<input type="file" name="foto" id="foto">
														<p></p>
													</div>
												</div>
											</div>
											<div id="pf">
												<div class="form-group">
													<label class="col-md-4 control-label">Número Pessoal</label>
													<div class="col-md-8">
														<input type="text" name="numero" id="numero" class="form-control input-md" size="8" maxlength="8" value="<?php echo $queryResult[$i]->numero ?>">
														<p></p>
													</div>
												</div>
											</div>
											<div id="pf">
												<div class="form-group">
													<label class="col-md-4 control-label" for="textinput">ASO</label>
													<div class="col-md-8">
														<input type="date" name="aso" id="aso" class="form-control input-md" value="<?php echo $queryResult[$i]->aso ?>">
														<p></p>
													</div>
												</div>
											</div>
											<div id="pf">
												<div class="form-group">
													<label class="col-md-4 control-label" for="textinput">Cargo</label>
													<div class="col-md-8">
														<input type="text" name="cargo" id="cargo" class="form-control input-md" value="<?php echo $queryResult[$i]->cargo ?>" required>
														<p></p>
													</div>
												</div>
											</div>
											<div id="pf">
												<div class="form-group">
													<label class="col-md-4 control-label" for="textinput">Status</label>
													<div class="col-md-8">
														<?php if($queryResult[$i]->status == 1) { ?>
														<input type="radio" name="status" value="1" checked>Ativo
														<input type="radio" name="status" value="0">Inativo
														<?php }else{ ?>
														<input type="radio" name="status" value="1">Ativo
														<input type="radio" name="status" value="0" checked>Inativo
														<?php } ?>
														<p></p>
													</div>
												</div>
											</div>
											<div id="pf">
												<div class="form-group">
													<label class="col-md-4 control-label" for="textinput">Célula</label>
													<div class="col-md-8">
														<select id="select" name="celulas_id" class="form-control" action="cadastrarArea.php" required>
															<option value="<?php echo $queryResult[$i]->celulas_id ?>">
																<?php
																$stmtCelula = $celula->index();
																while ($rowCelula = $stmtCelula->fetch(PDO::FETCH_OBJ)) {
																	if ($rowCelula->id == $queryResult[$i]->celulas_id) {
																		?>
																		<td><?php echo $rowCelula->nome; ?></td>
																		<?php } } ?>
																	</option>
																	<?php
																	$stmt = $celula->index();
																	while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
																		?>
																		<option id="<?php echo $row->id; ?>" value="<?php echo $row->id; ?>"> <?php echo $row->nome; ?>
																		</option>
																		<?php
																	}
																	?>
																</select>
															</div>
														</div>
													</div>
													<div id="pf">
														<div class="form-group">
															<div id="botao" align="center">
																<input type="hidden" name="idFunc" value="<?php echo $queryResult[$i]->idFunc; ?>">
																<button type="submit" name="edit" class="btn btn-sm" id="btncadastrar">Salvar</button>
															</div>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<?php include 'assets/templates/footer.php';?>
								<script src="assets/js/jquery.min.js"></script>
								<script src="assets/js/bootstrap.min.js"></script>
								<script src="assets/js/funcoes.js"></script>
								<script type="text/javascript">
									$(".alert-success").fadeTo(1000, 500).slideUp(300, function(){
										$(".alert-success").alert('close');
										window.location.href = "cadastrarFuncionario.php";
									});
									$(".alert-danger").fadeTo(1000, 500).slideUp(300, function(){
										$(".alert-danger").alert('close');
										window.location.href = "cadastrarFuncionario.php";
									});
								</script>
							</body>