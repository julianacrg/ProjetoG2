<?php

require_once "database.php";

class Formularios{

	private $idForm;
	private $nomeForm;
	private $data;

	public function __construct() {
		$database = new Database();
		$dbSet = $database->dbSet();
		$this->conn = $dbSet;
	}

	function setId($value){
		$this->idForm = $value;
	}

	function setNome($value){
		$this->nomeForm = $value;
	}

	function setData($value){
		$this->data = $value;
	}

	public function insert(){
		try{
			$stmt = $this->conn->prepare("INSERT INTO `formularios`(`nomeForm`, `data`) VALUES (:nomeForm, :data)");
			$stmt->bindParam(":nomeForm", $this->nomeForm);
			$stmt->bindParam(":data", $this->data);
			$stmt->execute();
			return $this->conn->lastInsertId();
		}catch(PDOException $e){
			echo $e->getMessage();
			return 0;
		}
	}

	public function edit(){
		try{
			$stmt = $this->conn->prepare("UPDATE `formularios` SET `nomeForm` = :nomeForm, `data` = :data WHERE `idForm` = :idForm");
			$stmt->bindParam(":idForm", $this->idForm);
			$stmt->bindParam(":nomeForm", $this->nomeForm);
			$stmt->bindParam(":data", $this->data);
			$stmt->execute();
			return 1;
		}catch(PDOException $e){
			echo $e->getMessage();
			return 0;
		}
	}
	
	public function delete(){
		try{
			$stmt = $this->conn->prepare("DELETE FROM `formularios` WHERE `idForm` = :idForm");
			$stmt->bindParam(":idForm", $this->idForm);
			$stmt->execute();
			return 1;
		}catch(PDOException $e){
			echo $e->getMessage();
			return 0;
		}
	}

	//A função abaixo exibe os dados referentes a um formulario
    /*public function pesquisa($nomeForm){
        try {
            $nomeForm = '%' . $nomeForm . '%';
            $stmt = $this->conn->prepare("SELECT * FROM `formularios` WHERE `nomeForm` LIKE :nomeForm;");
            $stmt->bindParam(":nomeForm", $nomeForm);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return $e;
        }
    }*/

	public function view(){
		$stmt = $this->conn->prepare("SELECT * FROM `formularios` WHERE `idForm` = :idForm");
		$stmt->bindParam(":idForm", $this->idForm);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		return $row;
	}

	public function index(){
		$stmt = $this->conn->prepare("SELECT * FROM `formularios` WHERE 1 ORDER BY `nomeForm`");
		$stmt->execute();
		return $stmt;
	}

	//A função abaixo conta a quantidade de cadastros na tabela
    public function contador(){
        $query = "SELECT count(*) FROM `formularios` WHERE 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

	//A função abaixo conta a quantidade de cadastros na tabela de acordo com o nome
    public function contadorPesquisa($nomeForm){
        $query = "SELECT count(*) FROM `formularios` WHERE `nomeForm` LIKE '%" . $nomeForm . "%'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nomeForm", $nomeForm);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //A função abaixo define o inicio e fim da paginacao
    public function paginacao($limite, $offset){
        try {
            $query = "SELECT * FROM `formularios` WHERE 1 ORDER BY `nomeForm` LIMIT :limite OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //A função abaixo define o inicio e fim da paginacao de acordo com o nome
    public function paginacaoPesquisa($limite, $offset, $nomeForm){
        try {
            $query = "SELECT * FROM `formularios` WHERE `nomeForm` LIKE :nomeForm ORDER BY `nomeForm` LIMIT :limite OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $nomeForm = '%' . $nomeForm . '%';
            $stmt->bindParam(":nomeForm", $nomeForm);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>