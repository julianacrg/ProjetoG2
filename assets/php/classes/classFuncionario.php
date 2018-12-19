<?php

require_once 'database.php';

class Funcionarios {

    private $idFunc;
    private $nome;
    private $email;
    private $foto;
    private $aso;
    private $cargo;
    private $numero;
    private $status;
    private $celulas_id;

    public function __construct() {        
        $database = new Database();
        $dbSet = $database->dbSet();
        $this->conn = $dbSet;
    }

    function setId($value) {
        $this->idFunc = $value;
    }

    function setNome($value) {
        $this->nome = $value;
    }

    function setEmail($value) {
        $this->email = $value;
    }


    function setFoto($value) {
        $this->foto = $value; 

    }

    function setAso($value) {
        $this->aso = $value;
    }

    function setCargo($value) {
        $this->cargo = $value;
    }


    function setNumero($value) {
        $this->numero = $value;
    }

    function setStatus($value) {
        $this->status = $value;
    }
    function setCelulasId($value) {
        $this->celulas_id = $value;
    }
    

    public function insert(){
        try{
            $stmt = $this->conn->prepare("INSERT INTO `funcionarios`(`nome`, `foto`, `numero`, `aso`,`cargo`, `status`, `celulas_id`) VALUES(:nome, :foto, :numero, :aso, :cargo, :status, :celulas_id)");
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":foto", $this->foto);
            $stmt->bindParam(":numero", $this->numero);
            $stmt->bindParam(":aso", $this->aso);
            $stmt->bindParam(":cargo", $this->cargo);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":celulas_id", $this->celulas_id);
            $stmt->execute();
            $this->id = $this->conn->lastInsertId();
            return 1;
        }catch(PDOException $e){
            echo $e->getMessage();
            return 0;
        }             
    }

    public function edit(){
        try{
            $stmt = $this->conn->prepare("UPDATE `funcionarios` SET `aso` = :aso, `cargo` = :cargo, `foto` = :foto, `nome` = :nome, `numero` = :numero, `status` = :status, `celulas_id` = :celulas_id WHERE `idFunc` = :idFunc");
            $stmt->bindParam(":idFunc", $this->idFunc);
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":foto", $this->foto);
            $stmt->bindParam(":numero", $this->numero);
            $stmt->bindParam(":aso", $this->aso);
            $stmt->bindParam(":cargo", $this->cargo);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":celulas_id", $this->celulas_id);
            
            $stmt->execute();
            return 1;
        }catch(PDOException $e){
            echo $e->getMessage();
            return 0;
        }
    }
    
    //A função abaixo exibe os dados referentes ao id
    public function view(){
        $stmt = $this->conn->prepare("SELECT * FROM `funcionarios` WHERE `idFunc` = :idFunc");
        $stmt->bindParam(":idFunc", $this->idFunc);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row;
    }

    //A função abaixo exibe os dados referentes a um funcionário
    public function pesquisa($nome)
    {
        try {
            $nome = '%' . $nome . '%';
            $stmt = $this->conn->prepare("SELECT * FROM `funcionarios` WHERE `nome` LIKE :nome ORDER BY `status` DESC;");
            $stmt->bindParam(":nome", $nome);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return $e;
        }
    }

    
    //A função abaixo exibe todos os dados da tabela
    public function index(){
        $stmt = $this->conn->prepare("SELECT * FROM `funcionarios` WHERE 1 ORDER BY `status` DESC, `nome` ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //A função abaixo conta a quantidade de cadastros na tabela
    public function contador(){
        $query = "SELECT count(*) FROM `funcionarios` WHERE 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //A função abaixo conta a quantidade de cadastros na tabela de acordo com o nome
    public function contadorPesquisa($nome, $status){
        $query = "SELECT count(*) FROM `funcionarios`";
        $condicao = array();
        if($nome != "" && $status == ""){
            array_push($condicao, "(`nome` LIKE :nome)");
        }
        if($status != "" && $nome == ""){
            array_push($condicao, "(`status` = :status)");
        }
        if($nome != "" && $status != ""){
            array_push($condicao, "(`nome` LIKE :nome)");
            array_push($condicao, "(`status` = :status)");
        }
        $sql = $query;

        if(count($condicao) > 0){
            $sql .= " WHERE " . implode(" AND ", $condicao);
        }

        $stmt = $this->conn->prepare($sql);

        if (stripos($sql, '`nome`') !== FALSE) {
            $nome = '%' . $nome . '%';
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        }
        if (stripos($sql, '`status`') !== FALSE) {
            $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        }


        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $stmt->fetchColumn();
    }

    //A função abaixo define o inicio e fim da paginacao
    public function paginacao($limite, $offset){
        try {
            $query = "SELECT * FROM `funcionarios` WHERE 1 ORDER BY `status` DESC, `nome` ASC LIMIT :limite OFFSET :offset";
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
    public function paginacaoPesquisa($limite, $offset, $nome, $status){
        try {
            $query = "SELECT * FROM `funcionarios` WHERE `nome` LIKE :nome AND `status` = :status ORDER BY `status` DESC, `nome` ASC LIMIT :limite OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $nome = '%' . $nome . '%';
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function paginacaoNome($limite, $offset, $nome){
        try {
            $query = "SELECT * FROM `funcionarios` WHERE `nome` LIKE :nome ORDER BY `nome` ASC LIMIT :limite OFFSET :offset";
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

    public function paginacaoStatus($limite, $offset, $status){
        try {
            $query = "SELECT * FROM `funcionarios` WHERE `status` LIKE :status LIMIT :limite OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getEmail(){
        $stmt = $this->conn->prepare("SELECT `email` FROM `login` WHERE `funcionario_id` = :idFunc");
        $stmt->bindParam(":idFunc", $this->idFunc);
         try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }
}