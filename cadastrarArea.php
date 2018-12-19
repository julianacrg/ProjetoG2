<?php 
require_once 'assets/php/cadastroArea.php'; 
include 'assets/templates/header.php';

use JasonGrimes\Paginator;
$area = new Areas();
?>

<title>Áreas</title>
<body>
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
        <form method="get" action="cadastrarArea.php">
          <div class="input-group h2">
            <input name="nome" class="form-control" id="nome" type="text" placeholder="Pesquisar áreas">
            <span class="input-group-btn">
              <button class="btn " id="pesquisar" type="submit" name="submit">
                <span class="glyphicon glyphicon-search"></span>
              </button>
              <button class="btn btn-primary" type="submit" id="limpar" onclick="limpa('cadastrarArea.php');" title="Limpar pesquisa">
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
              <th>Área</th>
              <th>Célula</th>
              <th class="actions">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            for($i=0;$i<sizeof($queryResult);$i++){
              ?>
              <tr>
                <td><?php echo $queryResult[$i]->nome ?></td>
                <?php
                $stmtCelula = $area->index();
                while ($rowCelula = $stmtCelula->fetch(PDO::FETCH_OBJ)) {
                  if ($rowCelula->id == $queryResult[$i]->celulas_id) {
                    ?>
                    <td><?php echo $rowCelula->nome; ?></td>
                    <?php } } ?>
                    <td class="actions">
                      <input type="hidden" name="id" value="<?php echo $queryResult[$i]->id ?>">
                      <a href="#" class="btn btn-sm" id="btncadastrar" data-toggle="modal" data-target="#edit<?php echo $queryResult[$i]->id; ?>" id="editModal">Editar</a>
                      <a class="btn btn-sm" id="btncadastrar"  href="#" data-toggle="modal" data-target="#delete<?php echo $queryResult[$i]->id ?> " id="deleteModal">Excluir</a>
                    </td>
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
          <!-- Modal cadastrar -->
          <div class="modal fade" id="cadastrar-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
            <div class="modal-dialog" modal-lg role="document">
              <div class="modal-content">
                <div class="modal-header" >
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" ><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="modalLabel">Cadastro de Área</h4>
                </div>
                <div class="modal-body">
                  <form method="post" action="cadastrarArea.php" class="celulas" id="celulas">
                    <div id="pf">
                      <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Nome da área</label>
                        <div class="col-md-8">
                          <input type="text" name="nome" class="form-control input-md" maxlength="45" size="45" required>
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
                            $stmt = $area->index();
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
                          <button type="submit" name="insert" class="btn btn-success btn-sm">Cadastrar</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal editar -->
          <?php
          for($i=0; $i<sizeof($queryResult); $i++){
            ?>
            <div class="modal fade" id="edit<?php echo $queryResult[$i]->id ;?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
              <div class="modal-dialog" modal-lg role="document">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Área</h4>
                  </div>
                  <div class="modal-body">
                    <form action="cadastrarArea.php" method="post" class="celulas" id="celulas">
                      <div id="pf">
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">Nome</label>
                          <div class="col-md-8">
                            <input type="text" name="nome" id="nome" class="form-control input-md" maxlength="45" size="45" value="<?php echo $queryResult[$i]->nome ?>" required>
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
                                $stmtCelula = $area->index();
                                while ($rowCelula = $stmtCelula->fetch(PDO::FETCH_OBJ)) {
                                  if ($rowCelula->id == $queryResult[$i]->celulas_id) {
                                    ?>
                                    <td><?php echo $rowCelula->nome; ?></td>
                                    <?php } } ?>
                                  </option>
                                  <?php
                                  $stmt = $area->index();
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
                                <input type="hidden" name="id" value="<?php echo $queryResult[$i]->id; ?>">
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
                <!-- Modal Excluir-->
                <?php
                for($i=0; $i<sizeof($queryResult); $i++){
                  ?>
                  <div class="modal fade" id="delete<?php echo $queryResult[$i]->id ;?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="modalLabel">Excluir Área</h4>
                        </div>
                        <form action="cadastrarArea.php" method="post">
                          <div class="modal-body">
                            Deseja realmente excluir a área <?php echo $queryResult[$i]->nome;?>?
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="delete" class="btn btn-primary" id="btncadastrar">Sim</button>
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
              </div>
              <?php include 'assets/templates/footer.php' ?>
              <script src="assets/js/jquery.min.js"></script>
              <script src="assets/js/bootstrap.min.js"></script>
              <script src="assets/js/funcoes.js"></script>
              <script type="text/javascript">
                $(".alert-success").fadeTo(1000, 500).slideUp(300, function(){
                  $(".alert-success").alert('close');
                });
                $(".alert-danger").fadeTo(1000, 500).slideUp(300, function(){
                  $(".alert-danger").alert('close');
                });
              </script>
            </body>
            </html>