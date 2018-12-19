<?php

require_once 'assets/php/classes/classPergunta.php';
require_once 'assets/php/classes/classOpcoes.php';
require_once 'assets/php/classes/classFormulario.php';
require_once 'assets/vendor/autoload.php';
require_once 'assets/php/classes/classResposta.php';

$resp = new Respostas();
$form = new Formularios();
$perg = new Perguntas();
$op = new Opcoes();


if(isset($_POST['submit'])){
	$form->setId($_POST['idForm']);
	$rowForm = $form->view();
}

if(isset($_POST['insert'])){

	$form->setId($_POST['idForm']);

	foreach($_POST['resposta'] as $resposta){
		$arrayResposta[] = $resposta;
	}

	foreach($_POST['idPerg'] as $perguntas_idPerg){
		$arrayIdPerg[] = $perguntas_idPerg;
	}
	
	$array = array_map(null, $arrayResposta, $arrayIdPerg);
	for($i=0;$i<count($array);$i++){
		$indice = 0;
		$resp->setResposta($array[$i][$indice]);
		$resp->setPerguntas_idPerg($array[$i][$indice+1]);	
		$resp->setPerguntas_formularios_idForm($_POST['idForm']);

		$respForm = $resp->insert();
		
	}
	$rowForm = $form->view();

	if($respForm){

		$result = "Resposta enviada!";
		$idForm = $_POST['idForm'];
		
		
	}else{
		$error = "Erro! Tente novamente";
		$idForm = $_POST['idForm'];
		
	}

	

}

?>