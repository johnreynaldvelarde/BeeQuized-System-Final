<?php

Class Database{

    /*
    public function db_connect(){

        try{

            $string = DB_TYPE . ":host=".DB_HOST.";dbname=".DB_NAME.";";
            return $db = new PDO($string, DB_USER, DB_PASS);
        }
        catch(PDOException $e){

            die($e->getMessage());

        }
    }

    public function read($query,$data = []){

        $DB = $this->db_connect();
		$stm = $DB->prepare($query);

        if(count($data) == 0){

            $stm = $DB->query($query);
            $check = 0;
            if($stm){
                $check = 1;
            }

        }
        else{
            $check = $stm->execute($data);
        }
        

        if($check){

            $data = $stm->fetchAll(PDO::FETCH_OBJ);
            if(is_array($data) && count($data) >0){
                return $data;
            }
            return false;
        }
        else{
            return false;
        }

    }

    public function write($query,$data = []){

        $DB = $this->db_connect();
		$stm = $DB->prepare($query);

        if(count($data) == 0){

            $stm = $DB->query($query);
            $check = 0;
            if($stm){
                $check = 1;
            }
        }
        else{
            $check = $stm->execute($data);
        }
        
        if($check){

            return true;
        }
        else{
            return false;
        }
    }
    */
    
    private $connection;

    public function __construct() {
        $this->connection = $this->db_connect();
    }

    public function db_connect() {
        try {
            $string = DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";";
            return new PDO($string, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            error_log('Database connection error: ' . $e->getMessage());
            die($e->getMessage());
        }
    }

    public function read($query, $data = []) {
        try {
            $DB = $this->connection;
            $stm = $DB->prepare($query);

            if (count($data) == 0) {
                $stm = $DB->query($query);
                $check = $stm ? 1 : 0;
            } else {
                $check = $stm->execute($data);
            }

            if ($check) {
                $data = $stm->fetchAll(PDO::FETCH_OBJ);
                return is_array($data) && count($data) > 0 ? $data : false;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log('Database read error: ' . $e->getMessage());
            return false;
        }
    }

    public function write($query, $data = []) {
        try {
            $DB = $this->connection;
            $stm = $DB->prepare($query);

            if (count($data) == 0) {
                $stm = $DB->query($query);
                $check = $stm ? 1 : 0;
            } else {
                $check = $stm->execute($data);
            }

            return $check ? true : false;
        } catch (PDOException $e) {
            error_log('Database write error: ' . $e->getMessage());
            return false;
        }
    }

    public function fetchSingle($query, $data = []) {
        $result = $this->read($query, $data);
        return $result ? $result[0] : null;
    }

    public function fetchColumn($query, $column, $data = []) {
        $result = $this->read($query, $data);
        if ($result && isset($result[0]->{$column})) {
            return $result[0]->{$column};
        }
        return null;
    }

    public function update($query, $data = []) {
        return $this->write($query, $data);
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    public function commit() {
        return $this->connection->commit();
    }

    public function rollBack() {
        return $this->connection->rollBack();
    }
}