<?php
require_once 'classes/classFormulario.php';
require_once 'assets/vendor/autoload.php';
use JasonGrimes\Paginator;
$form = new Formularios();

//Paginacao
$maxPorPagina = 10;
$paginaAtual = filter_var(isset($_GET['pagina']) ? $_GET['pagina'] : 1, FILTER_SANITIZE_NUMBER_INT);
$url = 'cadastrarFormulario.php?pagina=(:num)';
$inicio = ($maxPorPagina * $paginaAtual) - $maxPorPagina;

if(isset($_GET['nome'])){
	$quantidade = $form->contadorPesquisa($_GET['nome']);
	$index = $form->paginacaoPesquisa($maxPorPagina, $inicio, $_GET['nome']);
	$url = 'cadastrarFormulario.php?pagina=(:num)&nome=' . $_GET['nome'];
	$queryResult = $index;
}else{
	$quantidade = $form->contador();
	$index = $form->paginacao($maxPorPagina, $inicio);
	$queryResult = $index;
}

$paginator = new Paginator($quantidade, $maxPorPagina, $paginaAtual, $url);
$paginator->setMaxPagesToShow(7);
    //Fim paginacao


if(isset($_POST['delete'])){
	$form->setId($_POST['id']);
	if($form->delete() == 1){
		$result = "Pratica deletada com sucesso!";
	}else{
		$error = "Erro ao deletar. Tente novamente";
	}
}

	//Fim delete


	//Pesquisa

if(isset($_POST['pesquisa'])){
	$stmt = $form->pesquisa($_POST['nomeForm']);
}
	//Fim pesquisa
?>