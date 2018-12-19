<?php

require_once 'database.php';

class Opcoes{

	private $idopcao;
	private $opcao;
    private $perguntas_idPerg;
	
	public function __construct(){
        $database = new Database();
        $dbSet = $database->dbSet();
        $this->conn = $dbSet;
    }

    public function setIdOpcao($value){
        $this->idopcao = $value;
    }

    public function setOpcao($value){
    	$this->opcao = $value;
    }

    public function setPergunta_id($value){
        $this->perguntas_idPerg = $value;
    }

    public function insert(){
        try{
            $stmt = $this->conn->prepare("INSERT INTO `opcoes`(`opcao`,`perguntas_idPerg`) VALUES(:opcao,:perguntas_idPerg)");
            $stmt->bindParam(":opcao", $this->opcao);
            $stmt->bindParam(":perguntas_idPerg", $this->perguntas_idPerg);
            $stmt->execute();
            return 1;
        }catch(PDOException $e){
            echo $e->getMessage();
            return 0; 
        }
    }

    public function edit(){
        try {
            $stmt = $this->conn->prepare("UPDATE `opcoes` SET `opcao` = :opcao WHERE `idopcao` = :idopcao AND `perguntas_idPerg` = :perguntas_idPerg");
            $stmt->bindParam(":idopcao", $this->idopcao);
            $stmt->bindParam(":opcao", $this->opcao);
            $stmt->bindParam(":perguntas_idPerg", $this->perguntas_idPerg);
            $stmt->execute();
            return 1;
        }catch(PDOException $e){
            echo $e->getMessage();
            return 0;
        }
    }

    public function delete(){
        try{
            $stmt = $this->conn->prepare("DELETE FROM `opcoes` WHERE `idopcao` = :idopcao");
            $stmt->bindParam(":idopcao", $this->idopcao);
            $stmt->execute();
            return 1;
        }catch(PDOException $e){
            return 0;
        }
    }

    public function view(){
        $stmt = $this->conn->prepare("SELECT * FROM `opcoes` WHERE `idopcao` = :idopcao");
        $stmt->bindParam(":idopcao", $this->idopcao);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row;
    }

    public function index(){
        $stmt = $this->conn->prepare("SELECT * FROM `opcoes` WHERE 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function indexRelatedTo($idPerg){
        $stmt = $this->conn->prepare("SELECT * FROM `opcoes` WHERE `opcoes`.`perguntas_idPerg` = :idperg");
        $stmt->bindParam(":idperg", $idPerg);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}


?>