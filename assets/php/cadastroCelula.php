<?php
require_once 'assets/php/classes/classCelula.php';
require_once 'assets/vendor/autoload.php';
use JasonGrimes\Paginator;
$celula = new Celulas();

//Paginacao
$maxPorPagina = 10;
$paginaAtual = filter_var(isset($_GET['pagina']) ? $_GET['pagina'] : 1, FILTER_SANITIZE_NUMBER_INT);
$url = 'cadastrarCelula.php?pagina=(:num)';
$inicio = ($maxPorPagina * $paginaAtual) - $maxPorPagina;

//Pesquisa
if(isset($_GET['nome'])){
  $quantidade = $celula->contadorPesquisa($_GET['nome']);
  $index = $celula->paginacaoPesquisa($maxPorPagina, $inicio, $_GET['nome']);
  $url = 'cadastrarCelula.php?pagina=(:num)&nome=' . $_GET['nome'];
  $queryResult = $index;
}else{
  $quantidade = $celula->contador();
  $index = $celula->paginacao($maxPorPagina, $inicio);
  $queryResult = $index;
}

$paginator = new Paginator($quantidade, $maxPorPagina, $paginaAtual, $url);
$paginator->setMaxPagesToShow(7);
//Fim paginacao
if(isset($_POST['insert'])){
	$celula->setNome($_POST['nome']);
	if($celula->insert() == 1){
		$result = "Célula cadastrada com sucesso!";
	}else{
		$error = "Erro ao cadastrar. Tente novamente";
	}
}
if(isset($_POST['edit'])){
	$celula->setId($_POST['id']);
	$celula->setNome($_POST['nome']);
	if($celula->edit() == 1){
		$result = "Célula editada com sucesso!";
	}else{
		$error = "Erro ao editar. Tente novamente";
	}
}
if(isset($_POST['delete'])){
	$celula->setId($_POST['id']);
	if($celula->delete() == 1){
		$result = "Célula deletada com sucesso!";
	}else{
		$error = "Erro ao deletar. Tente novamente";
	}
}
?>