<?php 

require_once 'model/procedure.php';
require_once 'controller/procedureController.php';

?>


<!DOCTYPE html>
<html>
<head>
    <title>Laboratório X</title>

    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

  <div class="container">

    <h1>Laboratório X</h1>

    <div class="container">
      <div class="row section-separator">
        <br><br>
        <h3 class="section-heading ">Criar Conta</h3>
        <div class="form-group">
          <div class="row">
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
            <br><br>

            <form id="cadastro" name="cadastro" method="post" enctype="multipart/form-data" action="index.php">
              <div class="form-group">

                <div class="row">
                  <div class="col-sm-4">
                    <label for="name">Nome:</label>
                    <input type="text" class="form-text" id="name" name="name" placeholder="" required><p></p>
                    <label for="email">E-mail:</label>
                    <input type="text" class="form-text" id="email" name="email" placeholder="" required><p></p>
                    <label for="senha">Senha:</label>
                    <input type="password" class="form-text" id="senha" name="senha" placeholder="" required><p></p>

                  </div>
                  <div class="col-sm-4">
                    <input type="submit" name="insertP" class="btn btn-secondary btn-sm" value="Criar"/>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>