<?php
 session_start();
  require_once "classes/classLogin.php";
  //require_once 'assets/vendor/autoload.php';

  $login = new Login();

  if(isset($_POST['login'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $login->setEmail($email);
    $login->setSenha($senha);
    $login = $login->locate();
    
  if((sha1($senha)) == $login->senha){
    if($login->tipo == 1){
      header("Location: ../../sistema.php");
    }else{
      header("Location: ../../sistemaFuncionario.php");
    }
    

  }else{
    header("Location: ../../index.php?retorno=1");
  }
}
?>
