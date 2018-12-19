<?php
require_once 'assets/php/classes/classPratica.php';
require_once 'assets/php/classes/classCelula.php';
require_once 'assets/vendor/autoload.php';
use JasonGrimes\Paginator;
$pratica = new Praticas();
$celula = new Celulas();
//Paginacao
$maxPorPagina = 10;
$paginaAtual = filter_var(isset($_GET['pagina']) ? $_GET['pagina'] : 1, FILTER_SANITIZE_NUMBER_INT);
$url = 'cadastrarPratica.php?pagina=(:num)';
$inicio = ($maxPorPagina * $paginaAtual) - $maxPorPagina;

if(isset($_GET['nome'])){
	$quantidade = $pratica->contadorPesquisa($_GET['nome']);
	$index = $pratica->paginacaoPesquisa($maxPorPagina, $inicio, $_GET['nome']);
	$url = 'cadastrarPratica.php?pagina=(:num)&nome=' . $_GET['nome'];
	$queryResult = $index;
}else{
	$quantidade = $pratica->contador();
	$index = $pratica->paginacao($maxPorPagina, $inicio);
	$queryResult = $index;
}

$paginator = new Paginator($quantidade, $maxPorPagina, $paginaAtual, $url);
$paginator->setMaxPagesToShow(7);


if (isset($_POST['select'])) {
	echo $_POST['id'];
	$pratica->setCelula($_POST['id']);
}
if(isset($_POST['insert'])){
	$pratica->setNome($_POST['nome']);
	$pratica->setCelula($_POST['celula_id']);

	if($pratica->insert() == 1){
		$result = "Prática cadastrada com sucesso!";
	}else{
		$error = "Erro ao cadastrar. Tente novamente";
	}
}
if(isset($_POST['edit'])){
	$pratica->setId($_POST['id']);
	$pratica->setNome($_POST['nome']);
	$pratica->setCelula($_POST['celula_id']);
	if($pratica->edit() == 1){
		$result = "Prática editada com sucesso!";
	}else{
		$error = "Erro ao editar. Tente novamente";
	}
}
if(isset($_POST['delete'])){
	$pratica->setId($_POST['id']);
	if($pratica->delete() == 1){
		$result = "Prática deletada com sucesso!";
	}else{
		$error = "Erro ao deletar. Tente novamente";
	}
}
?>