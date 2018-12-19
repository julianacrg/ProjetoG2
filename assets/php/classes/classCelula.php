<?php

require_once "database.php";

class Celulas{

	private $id;
	private $nome;

	public function __construct() {
		$database = new Database();
		$dbSet = $database->dbSet();
		$this->conn = $dbSet;
	}

	function setId($value){
		$this->id = $value;
	}

	function setNome($value){
		$this->nome = $value;
	}

	public function insert(){
		try{
			$stmt = $this->conn->prepare("INSERT INTO `celulas`(`nome`) VALUES (:nome)");
			$stmt->bindParam(":nome", $this->nome);
			$stmt->execute();
			return 1;
		}catch(PDOException $e){
			echo $e->getMessage();
			return 0;
		}
	}

	public function edit(){
		try{
			$stmt = $this->conn->prepare("UPDATE `celulas` SET `nome` = :nome WHERE `id` = :id");
			$stmt->bindParam(":id", $this->id);
			$stmt->bindParam(":nome", $this->nome);
			$stmt->execute();
			return 1;
		}catch(PDOException $e){
			echo $e->getMessage();
			return 0;
		}
	}
	
	public function delete(){
		try{
			$stmt = $this->conn->prepare("DELETE FROM `celulas` WHERE `id` = :id");
			$stmt->bindParam(":id", $this->id);
			$stmt->execute();
			return 1;
		}catch(PDOException $e){
			echo $e->getMessage();
			return 0;
		}
	}

	public function view(){
		$stmt = $this->conn->prepare("SELECT * FROM `celulas` WHERE `id` = :id");
		$stmt->bindParam(":id", $this->id);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		return $row;
	}

	public function index(){
		$stmt = $this->conn->prepare("SELECT * FROM `celulas` WHERE 1 ORDER BY `nome`");
		$stmt->execute();
		return $stmt;
	}

	//A função abaixo conta a quantidade de cadastros na tabela
    public function contador(){
        $query = "SELECT count(*) FROM `celulas` WHERE 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
 
	//A função abaixo conta a quantidade de cadastros na tabela de acordo com o nome
    public function contadorPesquisa($nome){
        $query = "SELECT count(*) FROM `celulas` WHERE `nome` LIKE '%" . $nome . "%'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nome", $nome);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //A função abaixo define o inicio e fim da paginacao
    public function paginacao($limite, $offset){
        try {
            $query = "SELECT * FROM `celulas` WHERE 1 ORDER BY `nome` LIMIT :limite OFFSET :offset";
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
    public function paginacaoPesquisa($limite, $offset, $nome){
        try {
            $query = "SELECT * FROM `celulas` WHERE `nome` LIKE :nome ORDER BY `nome` LIMIT :limite OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $nome = '%' . $nome . '%';
            $stmt->bindParam(":nome", $nome);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>