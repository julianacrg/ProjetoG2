<!DOCTYPE html>
<html lang="pt-br" class="classLogin">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="assets/images/favicon.png"/> 
  <title>Sistema Gerdau</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="login">
  <div class="container">
    <div class="card card-container">
      <img id="imagemlogin" class="imagemlogin" src="assets/images/Gerdau-logo.png" />
      <p id="imagemlogin" class="imagemlogin"></p>

      <form class="form-signin" action="assets/php/login.php" method="post">
        <span id="reauth-email" class="reauth-email"></span>
        <div class="senhaIncorreta" <?php if(isset($_GET['retorno'])){ echo 'style="display: block;"'; } ?>>Senha Incorreta!</div>
        <input type="email" class="form-control" name="email" placeholder="E-mail" required autofocus>
        <input type="password" class="form-control" name="senha" placeholder="Senha" required>
        <div id="remember" class="checkbox">
          <label>
              <input type="checkbox" value="">Lembrar-me

          </label>
        </div>

        <button class="btn btn-lg btn-primary btn-block btn-signin" id="btnentrar" type="submit" name="login">Entrar</button>

      </form><!-- /form -->
    <a href="esqueceuSenha.php" data-toggle="modal" data-target="#senha-modal">
      Esqueceu a senha?
    </a>
  </div><!-- /card-container -->
</div><!-- /container -->


<!-- Modal Esqueci Senha-->
<div class="modal fade" id="senha-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" modal-lg role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Digite seu e-mail</h4>
        <div class="modal-body">
         <!-- Text input-->
         <div id="pf">
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">E-mail</label>
            <div class="col-md-8">
              <form action="">
              <input placeholder="Seu e-mail" name="e-mail" type="text">
              <input id="ok" name="ok" type="submit"
              class="form-control input-md">
              <p></p>
            </div>
          </div>
        </div>
        <div id="botaosenha">
          <div class="form-group">
            <div id="botao" align="center">
              <button type="button" class="btn btn-primary">Enviar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>