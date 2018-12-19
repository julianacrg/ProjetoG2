<?php
require_once "assets/php/classes/classArea.php";
require_once "assets/php/classes/classCelula.php";
require_once 'assets/vendor/autoload.php';

use JasonGrimes\Paginator;

$area = new Areas();
$celula = new Celulas();

   //Paginacao
$maxPorPagina = 10;
$paginaAtual = filter_var(isset($_GET['pagina']) ? $_GET['pagina'] : 1, FILTER_SANITIZE_NUMBER_INT);
$url = 'cadastrarArea.php?pagina=(:num)';
$inicio = ($maxPorPagina * $paginaAtual) - $maxPorPagina;

//Pesquisa
if(isset($_GET['nome'])){
  $quantidade = $area->contadorPesquisa($_GET['nome']);
  $index = $area->paginacaoPesquisa($maxPorPagina, $inicio, $_GET['nome']);
  $url = 'cadastrarArea.php?pagina=(:num)&nome=' . $_GET['nome'];
  $queryResult = $index;
}else{
  $quantidade = $area->contador();
  $index = $area->paginacao($maxPorPagina, $inicio);
  $queryResult = $index;
}

$paginator = new Paginator($quantidade, $maxPorPagina, $paginaAtual, $url);
$paginator->setMaxPagesToShow(7);
  //Fim paginacao

if (isset($_POST['select'])) {
  echo $_POST['id'];
  $area->setCelula($_POST['id']);
}

if(isset($_POST['insert'])){
	$area->setNome($_POST['nome']);
  $area->setCelula($_POST['celulas_id']);

  if($area->insert() == 1){
    $result = "Área cadastrada com sucesso!";
  }else{
    $error = "Erro ao cadastrar. Tente novamente";
  }
}

if(isset($_POST['edit'])){
	$area->setId($_POST['id']);
	$area->setNome($_POST['nome']);
  $area->setCelula($_POST['celulas_id']);

	if($area->edit() == 1){
		$result = "Área editada com sucesso!";
	}else{
		$error = "Erro ao editar. Tente novamente";
	}
}

if(isset($_POST['delete'])){
	$area->setId($_POST['id']);

	if($area->delete() == 1){
		$result = "Área deletada com sucesso!";
	}else{
		$error = "Erro ao deletar. Tente novamente";
	}
}

?>