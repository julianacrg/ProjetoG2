<?php
require_once 'database.php';
class Login
{
	private $senha;
	private $email;
	private $tipo;
	private $idLogin;
	private $funcionario_id;

	function __construct(){
		$database = new Database();
		$dbSet = $database->dbSet();
		$this->conn = $dbSet;
	}

	public function setSenha($value){
		$this->senha = $value;
	}

	public function setEmail($value){
		$this->email = $value;
	}

	public function setTipo($value){
		$this->tipo = $value;
	}

	public function setIdLogin($value){
		$this->idLogin = $value;
	}
	public function setFuncionario_id($value){
		$this->funcionario_id = $value;
	}

	public function getEmail(){
		return $this->$email;
	}

	public function getSenha(){
		return $this->$senha;
	}

	public function insert(){
		$stmt = $this->conn->prepare("INSERT INTO `login`(`email`, `senha`, `tipo`, `funcionario_id`) VALUES (:email, :senha, :tipo, :funcionario_id);");
		$stmt->bindParam(":email", $this->email);
		$this->senha = sha1($this->senha);
		$stmt->bindParam(":senha", $this->senha);
		$stmt->bindParam(":tipo", $this->tipo);
		$stmt->bindParam(":funcionario_id", $this->funcionario_id);
		$stmt->execute();
		return 1;
	}

	public function view(){
		$stmt = $this->conn->prepare("SELECT * FROM `login` WHERE `id` = :id;");
		$stmt->bindParam(":id", $this->id);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		return $row;
	}

	public function locate(){
		try{
			$stmt = $this->conn->prepare("SELECT * FROM `login` WHERE `email` = :email");
			$stmt->bindParam(":email", $this->email);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_OBJ);
			return $row;
		}catch(PDOException $e){
			echo $e->getMessage();
			return $e;
		}
	}

	public function recuperaEmail($email){
		try{
			$stmt = $this->conn->prepare("SELECT * FROM `login` WHERE `email` = :email ");
			$stmt->bindParam(":email", $email);
			$stmt->execute();
			if ($stmt->fetch(PDO::FETCH_OBJ)){
				return true;
			}else{
				return false;
			};
		}catch(PDOException $e){
			return $e;
		}
	}

	public function edit($email, $senha){
		try{
			$stmt = $this->conn->prepare("UPDATE `login` SET `senha` = :senha WHERE `email` = :email");
			$stmt->bindParam(":email", $email);
			$senha = sha1($senha);
			$stmt->bindParam(":senha", $senha);
			$stmt->execute();
			return true;
		}catch(PDOException $e){
			echo $e;
			return false;
		}
	}

	public function index(){
		$stmt = $this->conn->prepare("SELECT * FROM `login` WHERE 1");
		$stmt->execute();
		return $stmt;
	}

	public function getIdFuncionario($funcionario_id){
		try{
			$stmt = $this->conn->prepare("SELECT * FROM `login` WHERE `funcionario_id` = :funcionario_id;");
			$stmt->bindParam(":funcionario_id", $funcionario_id);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_OBJ);
			return $row;
		}catch(PDOException $e){
			echo $e->getMessage();
			return $e;
		}
	}

}
?>