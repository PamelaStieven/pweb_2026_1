<?php

class db {

    private $host     = 'localhost';
    private $user     = 'root';
    private $password = '';
    private $port     = '3306';
    private $dbname   = 'db_pweb_pamelapaola_banco';
    private $table_name;
    private $conn;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->conn = $this->connect();
    }

    private function connect()
    {
        try {
            return new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;port=$this->port;charset=utf8",
                $this->user,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }
    }

    public function all(){
        $sql = "SELECT * FROM $this->table_name";
        $st = $this->conn->prepare($sql);
        $st->execute();

        return $st->fetchAll(PDO::FETCH_CLASS);
    }

    public function findBy($campo, $valor)
    {
        try {
            $sql = "SELECT * FROM $this->table_name WHERE $campo = ?";
            $st = $this->conn->prepare($sql);
            $st->execute([$valor]); 

            return $st->fetchObject();
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar: " . $e->getMessage());
        }
    }

    public function store($dados){

        if (!isset($dados['id'])) {
            $sql = "SELECT COALESCE(MAX(id),0)+1 AS id FROM $this->table_name";
            $st = $this->conn->prepare($sql);
            $st->execute();
            $dados['id'] = $st->fetchObject()->id;
        }

        $campos = "";
        $marcadores = "";
        $vetorData = [];
        $sep = "";

        foreach($dados as $campo => $valor) {
            $campos .= $sep . $campo;
            $marcadores.= $sep . "?";
            $vetorData[] = $valor;
            $sep = ",";
        }

        $sql = "INSERT INTO $this->table_name ($campos) VALUES ($marcadores);";

        try{
            $st = $this->conn->prepare($sql);
            $st->execute($vetorData);
        }catch(PDOException $e){
            throw new Exception("Erro ao inserir: " . $e->getMessage());
        }
    }

    public function destroy($id){
        try{
            $sql = "DELETE FROM $this->table_name WHERE id=?";
            $st = $this->conn->prepare($sql);
            $st->execute([$id]);
        } catch(PDOException $e){
            throw new Exception("Erro ao deletar: " . $e->getMessage());
        }
    }

    public function search($dados){
        try{
            $campo = $dados['tipo'];
            $valor = $dados['valor'];

            $permitidos = ['nome', 'sobrenome', 'telefone', 'email', 'login'];

            if (!in_array($campo, $permitidos)) {
                $campo = 'nome';
            }

            $sql = "SELECT * FROM $this->table_name WHERE $campo LIKE ?";

            $st = $this->conn->prepare($sql);
            $st->execute(["%$valor%"]);

            return $st->fetchAll(PDO::FETCH_CLASS);

        } catch(PDOException $e){
            throw new Exception("Erro ao buscar: " . $e->getMessage());
        }
    }

    public function find($id){
        $sql = "SELECT * FROM $this->table_name WHERE id = ?";
        $st = $this->conn->prepare($sql);
        $st->execute([$id]);

        return $st->fetchObject();
    }

    public function update($dados){
        $campos = "";
        $vetorData = [];
        $sep = "";

        foreach($dados as $campo => $valor) {
            if ($campo !== "id" && $campo !== "multa") {
                $campos .= $sep . "$campo = ?";
                $vetorData[] = $valor;
                $sep = ",";
            }
        }

        $vetorData[] = $dados['id'];
        $sql = "UPDATE $this->table_name SET $campos WHERE id = ?";

        try{
            $st = $this->conn->prepare($sql);
            $st->execute($vetorData);
        } catch(PDOException $e){
            throw new Exception("Erro ao atualizar: " . $e->getMessage());
        }
    }
}