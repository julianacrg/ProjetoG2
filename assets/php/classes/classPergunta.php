<?php

require_once 'database.php';

class Perguntas{

	private $idPerg;
	private $pergunta;
	private $tipo;
    private $formularios_idForm;


	public function __construct(){
        $database = new Database();
        $dbSet = $database->dbSet();
        $this->conn = $dbSet;
    }

    public function setIdPerg($value){
        $this->idPerg = $value;
    }

    public function setPergunta($value){
    	$this->pergunta = $value;
    }

    public function setTipo($value){
    	$this->tipo = $value;
    }

    public function setFormulario_id($value){
        $this->formularios_idForm = $value;
    }

    public function insert(){
        try{
            $stmt = $this->conn->prepare("INSERT INTO `perguntas`(`pergunta`,`tipo`,`formularios_idForm`) VALUES(:pergunta,:tipo,:formularios_idForm)");
            $stmt->bindParam(":pergunta", $this->pergunta);
            $stmt->bindParam(":tipo", $this->tipo);
            $stmt->bindParam(":formularios_idForm", $this->formularios_idForm);
            $stmt->execute();
            return $this->conn->lastInsertId();
        }catch(PDOException $e){
            echo $e->getMessage();
            return $e; 
        }
    }

    public function edit(){
        try {
            $stmt = $this->conn->prepare("UPDATE `perguntas` SET `pergunta` = :pergunta,`tipo` = :tipo, `formularios_idForm` = :formularios_idForm WHERE `idPerg` = :idPerg");
            $stmt->bindParam(":idPerg", $this->idPerg);
            $stmt->bindParam(":pergunta", $this->pergunta);
            $stmt->bindParam(":tipo", $this->tipo);
            $stmt->bindParam(":formularios_idForm", $this->formularios_idForm);
            $stmt->execute();
            return 1;
        }catch(PDOException $e){
            echo $e->getMessage();
            return 0;
        }
    }

    public function delete(){
        try{
            $stmt = $this->conn->prepare("DELETE FROM `perguntas` WHERE `idPerg` = :idPerg");
            $stmt->bindParam(":idPerg", $this->idPerg);
            $stmt->execute();
            return 1;
        }catch(PDOException $e){
            echo $e->getMessage();
            return 0;
        }
    }

    public function view(){
        $stmt = $this->conn->prepare("SELECT * FROM `perguntas` WHERE `idPerg` = :idPerg");
        $stmt->bindParam(":idPerg", $this->idPerg);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row;
    }

    public function index(){
        $stmt = $this->conn->prepare("SELECT * FROM `perguntas` WHERE 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }   

}



?>


