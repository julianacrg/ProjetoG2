<?php 

	require_once 'database.php';

	

	class Indicadores{
		private $id;
		private $estrutura;
		private $codigo;
		private $medida;
		private $periodo;
		private $previsto;
		private $realizado;
		private $prev_acumulado;
		private $real_acumulado;
		private $farol;
		private $farol_acumulado;
		private $celula_id;		

		
		function __construct(){
			$database = new Database();
			$dbSet = $database->dbSet();
			$this->conn = $dbSet;
		}

		function setId($value){
			$this->id = $value;
		}

		function setEstrutura($value){
			$this->estrutura = $value;
		}

		function setCodigo($value){
			$this->codigo = $value;
		}
		function setMedida($value){
			$this->medida = $value;
		}
		function setPeriodo($value){
			$this->periodo = $value;
		}
		function setPrevisto($value){
			$this->previsto = $value;
		}
		function setRealizado($value){
			$this->realizado = $value;
		}
		function setPrev_Acumulado($value){
			$this->prev_acumulado = $value;
		}
		function setReal_Acumulado($value){
			$this->real_acumulado = $value;
		}
		function setFarol($value){
			$this->farol = $value;
		}
		function setFarolAcumulado($value){
			$this->farol_acumulado = $value;
		}
		
		function setCelula($value){
			$this->celula_id = $value;
		}

		public function insert(){
			try{
				$stmt = $this->conn->prepare("INSERT INTO `indicadores`(`estrutura`,`codigo`,`medida`,`periodo`,`previsto`,`realizado`,`farol`,`prev_acumulado`,`real_acumulado`,`farol_acumulado`,`celula_id`) VALUES (:estrutura,:codigo,:medida,:periodo,:previsto,:realizado,:farol,:prev_acumulado,:real_acumulado, :farol_acumulado,:celula_id)");
				$stmt->bindParam(":estrutura", $this->estrutura);
				$stmt->bindParam(":codigo", $this->codigo);
				$stmt->bindParam(":medida", $this->medida);
				$stmt->bindParam(":periodo", $this->periodo);
				$stmt->bindParam(":previsto", $this->previsto);
				$stmt->bindParam(":realizado", $this->realizado);
				$stmt->bindParam(":farol", $this->farol);
				$stmt->bindParam(":prev_acumulado", $this->prev_acumulado);
				$stmt->bindParam(":real_acumulado", $this->real_acumulado);
				$stmt->bindParam(":farol_acumulado", $this->farol_acumulado);
				$stmt->bindParam(":celula_id", $this->celula_id);
				$stmt->execute();				
				return 1;
			}catch(PDOException $e){
				echo $e->getMessage();
				return 0;
			}
		}

		public function edit(){
			try{
				$stmt = $this->conn->prepare("UPDATE `indicadores` SET `estrutura` = :estrutura,`codigo` = :codigo,`medida` = :medida,`periodo` = :periodo,`previsto` = :previsto,`realizado` = :realizado,`farol` = :farol,`prev_acumulado` = :prev_acumulado,`real_acumulado` = :real_acumulado,`farol_acumulado` = :farol_acumulado,`celula_id` = :celula_id WHERE `id` = :id");
				$stmt->bindParam(":id", $this->id);
				$stmt->bindParam(":estrutura", $this->estrutura);
				$stmt->bindParam(":codigo", $this->codigo);
				$stmt->bindParam(":medida", $this->medida);
				$stmt->bindParam(":periodo", $this->periodo);
				$stmt->bindParam(":previsto", $this->previsto);
				$stmt->bindParam(":realizado", $this->realizado);
				$stmt->bindParam(":farol", $this->farol);
				$stmt->bindParam(":prev_acumulado", $this->prev_acumulado);
				$stmt->bindParam(":real_acumulado", $this->real_acumulado);
				$stmt->bindParam(":farol_acumulado", $this->farol_acumulado);
				$stmt->bindParam(":celula_id", $this->celula_id);
				$stmt->execute();
				return 1;
			}catch(PDOException $e){
				echo $e->getMessage();
				return 0;
			}
		}
		
		public function delete(){
			try{
				$stmt = $this->conn->prepare("DELETE FROM `indicadores` WHERE `id` = :id");
				$stmt->bindParam(":id", $this->id);
				$stmt->execute();
				return 1;
			}catch(PDOException $e){
				echo $e->getMessage();
				return 0;
			}
		}

		public function view(){
			$stmt = $this->conn->prepare("SELECT * FROM `indicadores` WHERE `id` = :id");
			$stmt->bindParam(":id", $this->id);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_OBJ);
			return $row;
		}
		//A função abaixo exibe os dados referentes a um indicador
		public function pesquisa($nome)
		    {
		        try {
		            $estrutura = '%' . $estrutura . '%';
		            $stmt = $this->conn->prepare("SELECT * FROM `indicadores` WHERE `estrutura` LIKE :estrutura;");
		            $stmt->bindParam(":estrutura", $estrutura);
		            $stmt->execute();
		            return $stmt->fetchAll(PDO::FETCH_OBJ);
		        } catch (PDOException $e) {
		            return $e;
		        }
		    }

		public function index(){
			$stmt = $this->conn->prepare("SELECT * FROM `indicadores` WHERE 1 ORDER BY `estrutura`");
			$stmt->execute();
			return $stmt;
		}

		//A função abaixo conta a quantidade de cadastros na tabela
	    public function contador(){
	        $query = "SELECT count(*) FROM `indicadores` WHERE 1";
	        $stmt = $this->conn->prepare($query);
	        $stmt->execute();
	        return $stmt->fetchColumn();
	    }

		//A função abaixo conta a quantidade de cadastros na tabela de acordo com o estrutura
	    public function contadorPesquisa($estrutura){
	        $query = "SELECT count(*) FROM `indicadores` WHERE `estrutura` LIKE '%" . $estrutura . "%'";
	        $stmt = $this->conn->prepare($query);
	        $stmt->bindParam(":estrutura", $estrutura);
	        $stmt->execute();
	        return $stmt->fetchColumn();
	    }

	    //A função abaixo define o inicio e fim da paginacao
	    public function paginacao($limite, $offset){
	        try {
	            $query = "SELECT * FROM `indicadores` WHERE 1 ORDER BY `estrutura` LIMIT :limite OFFSET :offset";
	            $stmt = $this->conn->prepare($query);
	            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
	            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	            $stmt->execute();
	            return $stmt->fetchAll(PDO::FETCH_OBJ);
	        } catch (PDOException $e) {
	            echo $e->getMessage();
	        }
	    }

	    //A função abaixo define o inicio e fim da paginacao de acordo com o estrutura
	    public function paginacaoPesquisa($limite, $offset, $estrutura){
	        try {
	            $query = "SELECT * FROM `indicadores` WHERE `estrutura` LIKE :estrutura ORDER BY `id`LIMIT :limite OFFSET :offset";
	            $stmt = $this->conn->prepare($query);
	            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
	            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	            $estrutura = '%' . $estrutura . '%';
	            $stmt->bindParam(":estrutura", $estrutura);
	            $stmt->execute();
	            return $stmt->fetchAll(PDO::FETCH_OBJ);
	        } catch (PDOException $e) {
	            echo $e->getMessage();
	        }
	    }
	}
 ?>