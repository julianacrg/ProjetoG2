<?php
require_once "classes/classFormulario.php";
require_once "classes/classPergunta.php";
require_once "classes/classOpcoes.php";
$form = new Formularios();
$perg = new Perguntas();
$op = new Opcoes();	


if(isset($_POST['submit'])){
	$form->setId($_POST['idForm']);
	$rowForm = $form->view();
}

if(isset($_GET['idForm'])){
  $_POST['idForm'] = $_GET['idForm'];
  $form->setId($_POST['idForm']);
  $rowForm = $form->view();
}

if(isset($_POST['insert'])){ 
	$form->setId($_POST['idForm']);
	$form->setNome($_POST['nomeForm']);
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('Y-m-d H:i');
	$form->setData($date);
	$resp = $form->edit();
	$rowForm = $form->view();

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

if(isset($_POST['edit'])){
//Editar nome do formulario
	$form->setId($_POST['idForm']);
	$form->setNome($_POST['nomeForm']);
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('Y-m-d H:i');
	$form->setData($date);
	$resp = $form->edit();
	$rowForm = $form->view();
//Fim editar nome do formulario

//Editar pergunta e opcoes
	foreach($_POST['idPerg'] as $idPerg){
		$arrayId[] = $idPerg;
	}
	foreach($_POST['pergunta'] as $pergunta){
		$arrayPergunta[] = $pergunta;
	}
	foreach($_POST['tipo'] as $tipo){
		$arrayTipo[] = $tipo;
		if($tipo == 3){
			foreach($_POST['idopcao3'] as $idopcao3){
				$arrayIdOp3[] = $idopcao3;
			}
			foreach($_POST['opcao3'] as $opcao3){
				$arrayOp3[] = $opcao3;
			}
		}else if($tipo == 4){
			foreach($_POST['idopcao4'] as $idopcao4){
				$arrayIdOp4[] = $idopcao4;
			}
			foreach($_POST['opcao4'] as $opcao4){
				$arrayOp4[] = $opcao4;
			}
		}
	}

	$totalTipo3 = $_POST['contTipo3'];
	$totalTipo4 = $_POST['contTipo4'];
	$indice = 0;

	if($totalTipo3 == 0 && $totalTipo4 != 0){//se o formulario nao tiver pergunta de multipla escolha
		$array = array_map(null,$arrayId, $arrayPergunta, $arrayTipo, $arrayIdOp4, $arrayOp4);
		for($i=0, $posicaoTipo = 0;$i<count($array) && $posicaoTipo<count($arrayTipo);$i++, $posicaoTipo++){
			if($arrayTipo[$posicaoTipo] == 4){
				$j=1;
				$cont = 0;
				while($j<=$totalTipo4){
					$perg->setIdPerg($array[$i][$indice]);
					$perg->setPergunta($array[$i][$indice+1]);
					$perg->setTipo($array[$i][$indice+2]);
					$op->setIdOpcao($array[$cont][$indice+3]);
					$op->setOpcao($array[$cont][$indice+4]);
					$op->setPergunta_id($array[$i][$indice]);

					$perg->setFormulario_id($rowForm->idForm);
					$respPerg = $perg->edit();
					$respOp = $op->edit();

					$j++;
					$cont++;
				}
			}else{
				$perg->setIdPerg($array[$i][$indice]);
				$perg->setPergunta($array[$i][$indice+1]);
				$perg->setTipo($array[$i][$indice+2]);

				$perg->setFormulario_id($rowForm->idForm);
				$respPerg = $perg->edit();
			}
		}
		if($resp == 1 && $respPerg == 1 && $respOp == 1){
			$result = "Formulário editado com sucesso!";
			$rowForm->idForm = $_POST['idForm'];
		}else{
			$error = "Erro ao editar. Tente novamente";
			$rowForm->idForm = $_POST['idForm'];
		}


	}else if($totalTipo4 == 0 && $totalTipo3 != 0){//se o formulario nao tiver pergunta de caixas de selecao
		$array = array_map(null,$arrayId, $arrayPergunta, $arrayTipo, $arrayIdOp3, $arrayOp3);
		for($i=0, $posicaoTipo = 0;$i<count($array) && $posicaoTipo<count($arrayTipo);$i++, $posicaoTipo++){
			if($arrayTipo[$posicaoTipo] == 3){
				$j=1;
				$cont = 0;
				while($j<=$totalTipo3){
					$perg->setIdPerg($array[$i][$indice]);
					$perg->setPergunta($array[$i][$indice+1]);
					$perg->setTipo($array[$i][$indice+2]);
					$op->setIdOpcao($array[$cont][$indice+3]);
					$op->setOpcao($array[$cont][$indice+4]);
					$op->setPergunta_id($array[$i][$indice]);

					$perg->setFormulario_id($rowForm->idForm);
					$respPerg = $perg->edit();
					$respOp = $op->edit();

					$j++;
					$cont++;
				}
			}else{
				$perg->setIdPerg($array[$i][$indice]);
				$perg->setPergunta($array[$i][$indice+1]);
				$perg->setTipo($array[$i][$indice+2]);

				$perg->setFormulario_id($rowForm->idForm);
				$respPerg = $perg->edit();
			}
		}

		if($resp == 1 && $respPerg == 1 && $respOp == 1){
			$result = "Formulário editado com sucesso!";
			$rowForm->idForm = $_POST['idForm'];
		}else{
			$error = "Erro ao editar. Tente novamente";
			$rowForm->idForm = $_POST['idForm'];
		}

	}else if($totalTipo3 == 0 && $totalTipo4 == 0){//se o formulario nao tiver pergunta de multipla escolha e nem caixas de selecao
		$array = array_map(null,$arrayId, $arrayPergunta, $arrayTipo);
		for($i=0;$i<count($array);$i++){
			$perg->setIdPerg($array[$i][$indice]);
			$perg->setPergunta($array[$i][$indice+1]);
			$perg->setTipo($array[$i][$indice+2]);

			$perg->setFormulario_id($rowForm->idForm);
			$respPerg = $perg->edit();
		}

		if($resp == 1 && $respPerg == 1){
			$result = "Formulário editado com sucesso!";
			$rowForm->idForm = $_POST['idForm'];
		}else{
			$error = "Erro ao editar. Tente novamente";
			$rowForm->idForm = $_POST['idForm'];
		}

	}else{//se o formulario tiver pergunta de multipla escolha e caixas de selecao
		$array = array_map(null,$arrayId, $arrayPergunta, $arrayTipo, $arrayIdOp3, $arrayOp3, $arrayIdOp4, $arrayOp4);
		for($i=0, $posicaoTipo = 0;$i<count($array) && $posicaoTipo<count($arrayTipo);$i++, $posicaoTipo++){
			if($arrayTipo[$posicaoTipo] == 3){
				$j = 1;
				$cont = 0;
				while($j<=$totalTipo3){
					$perg->setIdPerg($array[$i][$indice]);
					$perg->setPergunta($array[$i][$indice+1]);
					$perg->setTipo($array[$i][$indice+2]);
					$op->setIdOpcao($array[$cont][$indice+3]);
					$op->setOpcao($array[$cont][$indice+4]);
					$op->setPergunta_id($array[$i][$indice]);

					$perg->setFormulario_id($rowForm->idForm);
					$respPerg = $perg->edit();
					$respOp = $op->edit();

					$j++;
					$cont++;
				}
			}else if($arrayTipo[$posicaoTipo] == 4){
				$k = 1;
				$contador = 0;
				while($k<=$totalTipo4){
					$perg->setIdPerg($array[$i][$indice]);
					$perg->setPergunta($array[$i][$indice+1]);
					$perg->setTipo($array[$i][$indice+2]);
					$op->setIdOpcao($array[$contador][$indice+5]);
					$op->setOpcao($array[$contador][$indice+6]);
					$op->setPergunta_id($array[$i][$indice]);

					$perg->setFormulario_id($rowForm->idForm);
					$respPerg = $perg->edit();
					$respOp = $op->edit();

					$k++;
					$contador++;
				}
			}else{
				$perg->setIdPerg($array[$i][$indice]);
				$perg->setPergunta($array[$i][$indice+1]);
				$perg->setTipo($array[$i][$indice+2]);

				$perg->setFormulario_id($rowForm->idForm);
				$respPerg = $perg->edit();
			}
		}
		if($resp == 1 && $respPerg == 1 && $respOp == 1){
			$result = "Formulário editado com sucesso!";
			$rowForm->idForm = $_POST['idForm'];
		}else{
			$error = "Erro ao editar. Tente novamente";
			$rowForm->idForm = $_POST['idForm'];
		}
	}//Fim editar pergunta e opcoes
	$rowP = $perg->view();
	$rowO = $op->view();
}

if(isset($_GET['deletePerg'])){
	$perg->setIdPerg($_GET['deletePerg']);
	$form->setId($_GET['idForm']);

	$rowForm = $form->view();

	$respPerg = $perg->delete();

	if($respPerg == 1){
		$result = "A pergunta e as respectivas respostas foram deletadas com sucesso!";
		$idForm = $_GET['idForm'];
		header("Location: ../../editarFormulario.php?idForm=".$idForm);
	}else{
		$error = "Erro ao deletar. Tente novamente";
		$idForm = $_GET['idForm'];
		header("Location: ../../editarFormulario.php?idForm=".$idForm);
	}
}


if(isset($_GET['deleteOp'])){
	$op->setIdOpcao($_GET['deleteOp']);
	$form->setId($_GET['idForm']);
	$perg->setIdPerg($_GET['idPerg']);

	$rowForm = $form->view();
	$rowP = $perg->view();
	$rowO = $op->view();

	var_dump($rowForm);

	$respOp = $op->delete();
	
	if($respOp == 1){
		$result = "Opção deletada com sucesso!";
		$idForm = $_GET['idForm'];
		$idPerg = $_GET['idPerg'];
		header("Location: ../../editarFormulario.php?idForm=".$idForm);
	}else{
		$error = "Erro ao deletar. Tente novamente";
		$rowForm->idForm = $_GET['idForm'];
		$rowP->idPerg = $_GET['idPerg'];
		header("Location: ../../editarFormulario.php?idForm=".$idForm);
	}
}

if(isset($_GET['insertOp'])){
	$form->setId($_GET['idForm']);
	$op->setOpcao($_GET['opcao']);
	$op->setPergunta_id($_GET['idPerg']);

	$respOp = $op->insert();

	if($respOp == 1){
		$result = "Opção inserida com sucesso!";
		$idForm = $_GET['idForm'];
		$idPerg = $_GET['idPerg'];
		header("Location: ../../editarFormulario.php?idForm=".$idForm);
	}else{
		$error = "Erro ao inserir. Tente novamente";
		$rowForm->idForm = $_GET['idForm'];
		$rowP->idPerg = $_GET['idPerg'];
		header("Location: ../../editarFormulario.php?idForm=".$idForm);
	}
}

?>