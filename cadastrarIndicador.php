<?php require_once 'assets/php/cadastroIndicador.php';
include 'assets/templates/header.php';
?>

<body>
  <title>Indicador</title>
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
      <form method="get" action="cadastrarIndicador.php">
        <div class="input-group h2">
          <input name="nome" class="form-control" id="nome" type="text" placeholder="Pesquisar Indicadores">
          <span class="input-group-btn">
            <button class="btn " id="pesquisar" type="submit" name="submit">
              <span class="glyphicon glyphicon-search"></span>
            </button>
            <button class="btn btn-primary" type="submit" id="limpar" type="submit" onclick="limpa('cadastrarIndicador.php');" title="Limpar pesquisa">
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
            <th>Estrutura</th>
            <th>Código</th>
            <th>Medida</th>
            <th>Periodo</th>
            <th>Previsto</th>
            <th>Realizado</th>
            <th>Prev Acumulado</th>
            <th>Real Acumulado</th>
            <th>Farol</th>
            <th>Farol Acumulado</th>
            <th>Célula</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          for($i=0;$i<sizeof($queryResult);$i++){
            ?>
            <tr>
              <td><?php echo $queryResult[$i]->estrutura ?></td>


              <td><?php echo $queryResult[$i]->codigo ?></td>
              <td><?php echo $queryResult[$i]->medida ?></td>
              <td><?php echo $queryResult[$i]->periodo ?></td>
              <td><?php echo $queryResult[$i]->previsto ?></td>
              <td><?php echo $queryResult[$i]->realizado ?></td>
              <td><?php echo $queryResult[$i]->prev_acumulado ?></td>
              <td><?php echo $queryResult[$i]->real_acumulado ?></td>
              <td><?php echo $queryResult[$i]->farol ?></td>
              <td><?php echo $queryResult[$i]->farol_acumulado ?></td>
              <?php
              $stmtCelula = $celula->index();
              while ($rowCelula = $stmtCelula->fetch(PDO::FETCH_OBJ)) {
                if ($rowCelula->id == $queryResult[$i]->celula_id) {
                  ?>
                  <td><?php echo $rowCelula->nome; ?></td>
                  <?php } } ?>                    <td class="actions">
                    <input type="hidden" name="id" value="<?php echo $queryResult[$i]->id ?>">
                    <button class="btn btn-sm" id="btncadastrar" data-toggle="modal" data-target="#edit<?php echo $queryResult[$i]->id; ?>" id="editModal">Editar</button>
                    <button class="btn btn-sm" id="btncadastrar" data-toggle="modal" data-target="#delete<?php echo $queryResult[$i]->id ?> " id="deleteModal">Excluir</button>
                  </td>
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
            <!-- /#bottom -->
          </div>
        </div>
      </div>
      <!-- Modal cadastrar -->
      <div class="modal fade" id="cadastrar-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header" >
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" ><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="modalLabel">Cadastro de Indicadores</h4>
            </div>
            <div class="modal-body">
              <form method="post" action="cadastrarIndicador.php" class="formulario" id="formulario" enctype="multipart/form-data">
                <div id="pf">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Estrutura</label>
                    <div class="col-md-8">
                      <input type="text" name="estrutura" class="form-control input-md"  placeholder="Estrutura Organizacional" required>
                      <p></p>
                    </div>
                  </div>
                </div>
                <div id="pf">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Codigo</label>
                    <div class="col-md-8">
                      <input type="text" name="codigo" class="form-control input-md" placeholder="Código IC" required>
                      <p></p>
                    </div>
                  </div>
                </div>
                <div id="pf">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Medida</label>
                    <div class="col-md-8">
                      <input type="text" name="medida" class="form-control input-md" placeholder="Unidade de Medida" required>
                      <p></p>
                    </div>
                  </div>
                </div>
                <div id="pf">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Periodo</label>
                    <div class="col-md-8">
                      <input type="number" name="periodo" class="form-control input-md" required>
                      <p></p>
                    </div>
                  </div>
                </div>
                <div id="pf">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Previsto</label>
                    <div class="col-md-8">
                      <input type="number" name="previsto" class="form-control input-md" required>
                      <p></p>
                    </div>
                  </div>
                </div>
                <div id="pf">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Realizado</label>
                    <div class="col-md-8">
                      <input type="number" name="realizado" class="form-control input-md" required>
                      <p></p>
                    </div>
                  </div>
                </div>
                <div id="pf">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Prev Acumulado</label>
                    <div class="col-md-8">
                      <input type="number" name="prev_acumulado" class="form-control input-md" required>
                      <p></p>
                    </div>
                  </div>
                </div>
                <div id="pf">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Real Acumulado</label>
                    <div class="col-md-8">
                      <input type="number" name="real_acumulado" class="form-control input-md" required>
                      <p></p>
                    </div>
                  </div>
                </div>
                <div id="pf">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Farol</label>
                    <div class="col-md-8">
                      <input type="number" name="farol" class="form-control input-md"  pattern="[0-9]" required>
                      <p></p>
                    </div>
                  </div>
                </div>  
                <div id="pf">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Farol Acumulado</label>
                    <div class="col-md-8">
                      <input type="number" name="farol_acumulado" class="form-control input-md" pattern="[0-9]" required>
                      <p></p>
                    </div>
                  </div>
                </div>
                <div id="pf">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Célula</label>
                    <div class="col-md-8">
                      <select id="select" name="celula_id" class="form-control" action="cadastrarIndicador.php">
                        <option value="select"> Selecione</option>
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
                    <div align="center">
                      <button type="submit" name="insert" class="btn btn-success btn-sm"  id="botao">Cadastrar</button>
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
                <h4 class="modal-title">Editar Indicador</h4>
              </div>
              <div class="modal-body">
                <form action="cadastrarIndicador.php" method="post" class="celula" id="celula">
                  <div id="pf">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Estrutura</label>
                      <div class="col-md-8">
                        <input type="text" name="estrutura" id="estrutura" class="form-control input-md" value="<?php echo $queryResult[$i]->estrutura ?>" required>
                        <p></p>
                      </div>
                    </div>
                  </div>

                  <div id="pf">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Código</label>
                      <div class="col-md-8">
                        <input type="text" name="codigo" id="codigo" class="form-control input-md" value="<?php echo $queryResult[$i]->codigo ?>" required>
                        <p></p>
                      </div>
                    </div>
                  </div>
                  <div id="pf">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Medida</label>
                      <div class="col-md-8">
                        <input type="text" name="medida" id="medida" class="form-control input-md" value="<?php echo $queryResult[$i]->medida ?>" required>
                        <p></p>
                      </div>
                    </div>
                  </div>
                  <div id="pf">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Período</label>
                      <div class="col-md-8">
                        <input type="number" name="periodo" id="periodo" class="form-control input-md" value="<?php echo $queryResult[$i]->periodo ?>" required>
                        <p></p>
                      </div>
                    </div>
                  </div>
                  <div id="pf">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Previsto</label>
                      <div class="col-md-8">
                        <input type="number" name="previsto" id="previsto" class="form-control input-md" value="<?php echo $queryResult[$i]->previsto ?>" required>
                        <p></p>
                      </div>
                    </div>
                  </div>
                  <div id="pf">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Realizado</label>
                      <div class="col-md-8">
                        <input type="number" name="realizado" id="realizado" class="form-control input-md" value="<?php echo $queryResult[$i]->realizado ?>" required>
                        <p></p>
                      </div>
                    </div>
                  </div>

                  <div id="pf">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Prev Acumulado</label>
                      <div class="col-md-8">
                        <input type="number" name="prev_acumulado" id="prev_acumulado" class="form-control input-md" value="<?php echo $queryResult[$i]->prev_acumulado ?>" required>
                        <p></p>
                      </div>
                    </div>
                  </div>
                  <div id="pf">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Real Acumulado</label>
                      <div class="col-md-8">
                        <input type="number" name="real_acumulado" id="real_acumulado" class="form-control input-md" value="<?php echo $queryResult[$i]->real_acumulado ?>" required>
                        <p></p>
                      </div>
                    </div>
                  </div>
                  <div id="pf">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Farol</label>
                      <div class="col-md-8">
                        <input type="text" name="farol" id="farol" class="form-control input-md" value="<?php echo $queryResult[$i]->farol ?>" required pattern="[0-9]">
                        <p></p>
                      </div>
                    </div>
                  </div>                    
                  <div id="pf">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Farol Acumulado</label>
                      <div class="col-md-8">
                        <input type="text" name="farol_acumulado" id="farol_acumulado" class="form-control input-md" value="<?php echo $queryResult[$i]->farol_acumulado ?>" required pattern="[0-9]">
                        <p></p>
                      </div>
                    </div>
                  </div>
                  <div id="pf">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Célula</label>
                      <div class="col-md-8">
                        <select id="select" name="celula_id" class="form-control" action="cadastrarIndicador.php" required>
                          <option value="<?php echo $queryResult[$i]->celula_id ?>">
                            <?php
                            $stmtCelula = $celula->index();
                            while ($rowCelula = $stmtCelula->fetch(PDO::FETCH_OBJ)) {
                              if ($rowCelula->id == $queryResult[$i]->celula_id) {
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
                      <h4 class="modal-title" id="modalLabel">Excluir Indicador</h4>
                    </div>
                    <form action="cadastrarIndicador.php" method="post">
                      <div class="modal-body">
                        Deseja realmente excluir o indicador <?php echo $queryResult[$i]->estrutura;?>?
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
        <?php include 'assets/templates/footer.php' ?>

        </html>
