<?php

require_once 'database.php';

class Respostas{

	private $idRes;
	private $resposta;
	private $perguntas_idPerg;
    private $perguntas_formularios_idForm;


    public function __construct(){
        $database = new Database();
        $dbSet = $database->dbSet();
        $this->conn = $dbSet;
    }

    public function setIdRes($value){
        $this->idRes = $value;
    }

    public function setResposta($value){
    	$this->resposta = $value;
    }

    public function setPerguntas_idPerg($value){
    	$this->perguntas_idPerg = $value;
    }

    public function setPerguntas_formularios_idForm($value){
        $this->perguntas_formularios_idForm = $value;
    }

    public function insert(){
        try{
            $stmt = $this->conn->prepare("INSERT INTO `respostas`(`resposta`,`perguntas_idPerg`,`perguntas_formularios_idForm`) VALUES(:resposta,:perguntas_idPerg,:perguntas_formularios_idForm)");
            $stmt->bindParam(":resposta", $this->resposta);
            $stmt->bindParam(":perguntas_idPerg", $this->perguntas_idPerg);
            $stmt->bindParam(":perguntas_formularios_idForm", $this->perguntas_formularios_idForm);
            $stmt->execute();
            return $this->conn->lastInsertId();
        }catch(PDOException $e){
            echo $e->getMessage();
            return $e; 
        }
    }

    public function edit(){
        try {
            $stmt = $this->conn->prepare("UPDATE `respostas` SET `resposta` = :resposta,`perguntas_idPerg` = :perguntas_idPerg, `perguntas_formularios_idForm` = :perguntas_formularios_idForm WHERE `idRes` = :idRes");
            $stmt->bindParam(":idRes", $this->idRes);
            $stmt->bindParam(":resposta", $this->resposta);
            $stmt->bindParam(":perguntas_idPerg", $this->perguntas_idPerg);
            $stmt->bindParam(":perguntas_formularios_idForm", $this->perguntas_formularios_idForm);
            $stmt->execute();
            return 1;
        }catch(PDOException $e){
            echo $e->getMessage();
            return 0;
        }
    }

    public function delete($idRes){
        try{
            $stmt = $this->conn->prepare("DELETE FROM `respostas` WHERE `idRes` = :idRes");
            $stmt->bindParam(":idRes", $this->idRes);
            $stmt->execute();
            return 1;
        }catch(PDOException $e){
            return 0;
        }
    }

    public function view(){
        $stmt = $this->conn->prepare("SELECT * FROM `respostas` WHERE `idRes` = :idRes");
        $stmt->bindParam(":idRes", $this->idRes);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row;
    }

    public function index(){
        $stmt = $this->conn->prepare("SELECT * FROM `respostas` WHERE 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }  
}

?>