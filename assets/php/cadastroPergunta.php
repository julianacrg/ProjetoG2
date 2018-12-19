<?php
require_once 'assets/php/classes/classPergunta.php';
require_once 'assets/php/classes/classOpcoes.php';
require_once 'assets/php/classes/classFormulario.php';
require_once 'assets/vendor/autoload.php';
$perg = new Perguntas();
$form = new Formularios();
$op = new Opcoes();
if(isset($_POST['insert'])){
	$form->setNome($_POST['nome']);
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('Y-m-d H:i');
	$form->setData($date);
	$idForm = $form->insert();
	if($idForm){
		$result = "Formulário cadastrado com sucesso!";
	}else{
		$error = "Formulário não cadastrado. Tente novamente";
	}
}
if(isset($_POST['insertP'])){
	$perg->setPergunta($_POST['pergunta']);
	$perg->setTipo($_POST['tipo']);
	$perg->setFormulario_id($_POST['idForm']);
	$resp = $perg->insert();
	$perg->setIdPerg($resp);
	$pergunta = $perg->view();
	//Se a pergunta for de multipla escolha ou caixa de seleção
	if($_POST['tipo'] == 3 || $_POST['tipo'] == 4){
		foreach($_POST['opcoes'] as $opcao){
			$op->setPergunta_id($pergunta->idPerg);
			$op->setOpcao($opcao);
			$op->insert();
		}
	}
	if($resp){
		$result = "Pergunta cadastrada com sucesso!";
		$idForm = $_POST['idForm'];
	}else{
		$error = "Pergunta não cadastrada. Tente novamente";
		$idForm = $_POST['idForm'];
	}
	
}
?>