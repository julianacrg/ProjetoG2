<?php
require_once "assets/php/classes/classLogin.php";
$usuario = new Login();
	if(isset($_POST['enviar'])){
		$email = $_POST['email'];
		//verifica vazio
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$error = "Email inválido";
		}
		else{
			//verifica se os dados existem no banco de dados
			if($usuario->recuperaEmail($email)){
				//cria nova senha
				$novasenha = substr(md5(time()), 0, 6);
				//envia nova senha para o email
				if(mail($email, "Sua nova senha", "Sua nova senha:".$novasenha)){
					//altera senha no BD
						$usuario->edit($email, $novasenha);
						$result = "Nova senha enviada para o email informado.";
				}
				else{
					$error = "Houve uma falha, tente novamente.";
				}
			}
			else{
				$error = "Email não cadastrado";
			}
		}
	}
?>

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
	<body class="login">
		<div class="card card-container">
			<img id="imagemlogin" class="imagemlogin" src="assets/images/Gerdau-logo.png" />
			<p id="imagemlogin" class="imagemlogin"></p>
			<form method="POST" action="esqueceuSenha.php">
				<input placeholder="Digite seu email" class="form-control" type="email" name="email">
			</br>
				<button type="submit" name="enviar" value="enviar" class="btn btn-lg btn-primary btn-block btn-signin" id="btnentrar">Enviar</button>
			</form><!-- /form -->
		</div><!-- /card-container -->
	</body>
</html>