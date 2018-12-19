<?php
require_once 'assets/php/classes/classIndicador.php';
require_once 'assets/php/classes/classCelula.php';
require_once 'assets/vendor/autoload.php';
use JasonGrimes\Paginator;
$indicador = new Indicadores();
$celula = new Celulas();

//Paginacao
$maxPorPagina = 10;
$paginaAtual = filter_var(isset($_GET['pagina']) ? $_GET['pagina'] : 1, FILTER_SANITIZE_NUMBER_INT);
$url = 'cadastrarIndicador.php?pagina=(:num)';
$inicio = ($maxPorPagina * $paginaAtual) - $maxPorPagina;

if(isset($_GET['nome'])){
  $quantidade = $indicador->contadorPesquisa($_GET['nome']);
  $index = $indicador->paginacaoPesquisa($maxPorPagina, $inicio, $_GET['nome']);
  $url = 'cadastrarIndicador.php?pagina=(:num)&nome=' . $_GET['nome'];
  $queryResult = $index;
}else{
  $quantidade = $indicador->contador();
  $index = $indicador->paginacao($maxPorPagina, $inicio);
  $queryResult = $index;
}

$paginator = new Paginator($quantidade, $maxPorPagina, $paginaAtual, $url);
$paginator->setMaxPagesToShow(7);
	//Fim paginacao


if (isset($_POST['select'])) {
	$indicador->setCelula($_POST['celula_id']);

}
if(isset($_POST['insert'])){
	$indicador->setEstrutura($_POST['estrutura']);
	$indicador->setCodigo($_POST['codigo']);
	$indicador->setMedida($_POST['medida']);
	$indicador->setPeriodo($_POST['periodo']);
	$indicador->setPrevisto($_POST['previsto']);
	$indicador->setRealizado($_POST['realizado']);
	$indicador->setFarol($_POST['farol']);
	$indicador->setPrev_Acumulado($_POST['prev_acumulado']);
	$indicador->setReal_Acumulado($_POST['real_acumulado']);
	$indicador->setFarolAcumulado($_POST['farol_acumulado']);
	$indicador->setCelula($_POST['celula_id']);

	if($indicador->insert() == 1){
		$result = "Indicador cadastrado com sucesso!";
	}else{
		$error = "Erro ao cadastrar. Tente novamente";
	}
	echo "<meta HTTP-EQUIV='refresh' CONTENT='1'>";

}
if(isset($_POST['edit'])){
	$indicador->setId($_POST['id']);
	$indicador->setEstrutura($_POST['estrutura']);
	$indicador->setCodigo($_POST['codigo']);
	$indicador->setMedida($_POST['medida']);
	$indicador->setPeriodo($_POST['periodo']);
	$indicador->setPrevisto($_POST['previsto']);
	$indicador->setRealizado($_POST['realizado']);
	$indicador->setFarol($_POST['farol']);
	$indicador->setPrev_Acumulado($_POST['prev_acumulado']);
	$indicador->setReal_Acumulado($_POST['real_acumulado']);
	$indicador->setFarolAcumulado($_POST['farol_acumulado']);
	$indicador->setCelula($_POST['celula_id']);

	if($indicador->edit() == 1){
		$result = "Indicador editado com sucesso!";
	}else{
		$error = "Erro ao editar. Tente novamente";
	}

}
if(isset($_POST['delete'])){
	$indicador->setId($_POST['id']);
	if($indicador->delete() == 1){
		$result = "Indicador deletado com sucesso!";
	}else{
		$error = "Erro ao deletar. Tente novamente";
	}

}
?>