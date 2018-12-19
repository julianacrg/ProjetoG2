<?php

require_once 'constants.php';

session_start();

if($acesso == __ACESSO_ADMINISTRADOR__){

	if ($_SESSION['tipo'] != __USUARIO_ADMINISTRADOR__ || !isset($_SESSION['tipo'])) {
    	header('Location: index.php');
	}

}
else if($acesso == __ACESSO_FUNCIONARIO__){

	if ($_SESSION['tipo'] != __USUARIO_FUNCIONARIO__ || !isset($_SESSION['tipo'])) {
    	header('Location: index.php');
	}

}
else if($acesso == __ACESSO_MISTO__){

	if ($_SESSION['tipo'] != __USUARIO_FUNCIONARIO__ || $_SESSION['tipo'] != __USUARIO_ADMINISTRADOR__ || !isset($_SESSION['tipo'])) {
    	header('Location: index.php');
	}

}


if (isset($_GET['action']) && $_GET['action'] == 'exit') {
    session_destroy();
    header('Location: index.php');
}
?>