<?php
require_once 'assets/php/classes/classFuncionario.php';
require_once 'assets/php/classes/classCelula.php';
require_once 'assets/php/classes/classLogin.php';
require_once 'assets/vendor/autoload.php';

use JasonGrimes\Paginator;
$func = new Funcionarios();
$celula = new Celulas();
$login = new Login();

//Paginacao
$maxPorPagina = 10;
$paginaAtual = filter_var(isset($_GET['pagina']) ? $_GET['pagina'] : 1, FILTER_SANITIZE_NUMBER_INT);
$url = 'cadastrarFuncionario.php?pagina=(:num)';
$inicio = ($maxPorPagina * $paginaAtual) - $maxPorPagina;

if(isset($_GET['nome']) && (isset($_GET['status']))){
  $nome = $_GET['nome'];
  $status = $_GET['status'];

  if($nome == "" && $status != ""){
    $quantidade = $func->contadorPesquisa($nome, $status);
    $index = $func->paginacaoStatus($maxPorPagina, $inicio, $status);
    $url = 'cadastrarFuncionario.php?pagina=(:num)&status=' . $_GET['status'];
    $queryResult = $index;
  }else if($nome != "" && $status == ""){
    $quantidade = $func->contadorPesquisa($nome, $status);
    $index = $func->paginacaoNome($maxPorPagina, $inicio, $nome);
    $url = 'cadastrarFuncionario.php?pagina=(:num)&nome=' . $_GET['nome'];
    $queryResult = $index;
  }else if($nome != "" && $status != ""){
    $quantidade = $func->contadorPesquisa($nome, $status);
    $index = $func->paginacaoPesquisa($maxPorPagina, $inicio, $nome, $status);
    $url = 'cadastrarFuncionario.php?pagina=(:num)&nome=' . $_GET['nome'] .  '&status=' . $_GET['status'];
    $queryResult = $index;
  }else{
    $quantidade = $func->contador();
    $index = $func->paginacao($maxPorPagina, $inicio);
    $url = 'cadastrarFuncionario.php?pagina=(:num)';
    $queryResult = $index;
  }

}else{
  $quantidade = $func->contador();
  $index = $func->paginacao($maxPorPagina, $inicio);
  $queryResult = $index;
}

$paginator = new Paginator($quantidade, $maxPorPagina, $paginaAtual, $url);
$paginator->setMaxPagesToShow(7);


    //Inserir dados     
if (isset($_POST['action'])){
  switch ($_POST['action']){
    case "insert":
    $func->setNome($_POST['nome']);  
    $func->setNumero($_POST['numero']);
    $func->setAso($_POST['aso']);
    $func->setCargo($_POST['cargo']);
    $func->setStatus($_POST['status']);
    $func->setCelulasId($_POST['celulas_id']);
    $foto = $_FILES["foto"];

    // Se a foto estiver sido selecionada
    if (!empty($foto["name"])) {
            // Pega extensão da imagem
      preg_match("/\.(png|jpg|jpeg){1}$/i", $foto["name"], $ext);
            // Gera um nome único para a imagem
      $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
            // Caminho de onde ficará a imagem
      $caminho_imagem = "assets/images/funcionarios/" . $nome_imagem;
            // Faz o upload da imagem para seu respectivo caminho
      move_uploaded_file($foto["tmp_name"], $caminho_imagem);
      $func->setFoto("assets/images/funcionarios/" . $nome_imagem);
    }
    else{
      $func->setFoto("assets/images/user.png");   
    }

    if($func->insert()){
      $login->setEmail($_POST['email']); 
      $login->setSenha($_POST['numero']); 
      $login->setTipo(2); 
      $login->setFuncionario_id($func->id);

      if($login->insert() == 1){
        $result = "Funcionário inserido com sucesso!";
      }
    }else{
      $error = "Erro ao inserir, tente novamente!";
    }
  }

} 

//editar dados
else if(isset($_POST['edit'])){
  $func->setId($_POST['idFunc']);
  $func->setNome($_POST['nome']); 
  $func->setNumero($_POST['numero']);
  $func->setAso($_POST['aso']);
  $func->setCargo($_POST['cargo']);
  $func->setStatus($_POST['status']);
  $func->setCelulasId($_POST['celulas_id']);
  $foto = $_FILES["foto"];

  // Se a foto estiver sido selecionada
  if (!empty($foto["name"])) {
              // Pega extensão da imagem
    preg_match("/\.(png|jpg|jpeg){1}$/i", $foto["name"], $ext);
              // Gera um nome único para a imagem
    $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
              // Caminho de onde ficará a imagem
    $caminho_imagem = "assets/images/funcionarios/" . $nome_imagem;
              // Faz o upload da imagem para seu respectivo caminho
    if($_POST['fotoatual'] != "assets/images/user.png"){
      unlink($_POST['fotoatual']);
    }
    move_uploaded_file($foto["tmp_name"], $caminho_imagem);
    $func->setFoto($caminho_imagem);

  }
  else{
    $func->setFoto($_POST['fotoatual']);
  }

  if($func->edit() == 1){
    $login->setEmail($_POST['email']); 
    $login->setSenha($_POST['numero']); 
    $login->setTipo(2); 
    $login->setFuncionario_id($_POST['idFunc']);
    if($login->insert()){
      $result = "Funcionário editado com sucesso!";
    }else{
      $error = "Erro ao editar, tente novamente!";
    }
  }else{
    $error = "Erro ao editar, tente novamente!";
  }
}

?>