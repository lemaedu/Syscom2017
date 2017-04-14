<?php

require(dirname(__FILE__) . "/Log.php");

class ConexPDO {

    private $Host;
    private $DBName;
    private $DBUser;
    private $DBPassword;
    private $pdo;
    private $sQuery;
    private $bConnected = false;
    private $log;
    private $parameters;
    public $rowCount = 0;
    public $columnCount = 0;
    public $querycount = 0;
    /* ---------------------------------------- */
    private $tipo_de_base;
    private $url; //dirección de la conexión que se usara para destruirla mas adelante

    public function __construct() {
        $this->Connect();
        $this->parameters = array();
    }

    public function cargarValores() {
        $this->log = new Log();
        $this->tipo_de_base = 'mysql';
        $this->DBUser = 'root';
        $this->DBPassword = '';
        $this->DBName = 'db_syscomandes';
        $this->Host = 'localhost';
        $this->url = $this->tipo_de_base . ':host=' . $this->Host . ';dbname=' . $this->DBName;
        date_default_timezone_set("America/Bogota");
        exec("SET CHARACTER SET utf8");
    }

    private function Connect() {
        try {
            $this->cargarValores();
            $this->pdo = new PDO($this->url, $this->DBUser, $this->DBPassword, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_EMULATE_PREPARES => false,
                //PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
            ));
            $this->bConnected = true;
        } catch (PDOException $e) {
            echo $this->ExceptionLog($e->getMessage());
            die();
        }
    }

    public function CloseConnection() {
        $this->pdo = null;
    }

    private function Init($query, $parameters = "") {
        if (!$this->bConnected) {
            $this->Connect();
        }
        try {
            $this->parameters = $parameters;
            $this->sQuery = $this->pdo->prepare($this->BuildParams($query, $this->parameters));

            if (!empty($this->parameters)) {
                if (array_key_exists(0, $parameters)) {
                    $parametersType = true;
                    array_unshift($this->parameters, "");
                    unset($this->parameters[0]);
                } else {
                    $parametersType = false;
                }
                foreach ($this->parameters as $column => $value) {
                    $this->sQuery->bindParam($parametersType ? intval($column) : ":" . $column, $this->parameters[$column]); //It would be query after loop end(before 'sQuery->execute()').It is wrong to use $value.
                }
            }

            $this->succes = $this->sQuery->execute();
            $this->querycount++;
        } catch (PDOException $e) {
            echo $this->ExceptionLog($e->getMessage(), $this->BuildParams($query));
            die();
        }
        $this->parameters = array();
    }

    private function BuildParams($query, $params = null) {
        if (!empty($params)) {
            $rawStatement = explode(" ", $query);
            foreach ($rawStatement as $value) {
                if (strtolower($value) == 'in') {
                    return str_replace("(?)", "(" . implode(",", array_fill(0, count($params), "?")) . ")", $query);
                }
            }
        }
        return $query;
    }

    public function query($query, $params = null, $fetchmode = PDO::FETCH_BOTH) {
        $query = trim($query);
        $rawStatement = explode(" ", $query);
        $this->Init($query, $params);
        $statement = strtolower($rawStatement[0]);
        if ($statement === 'select' || $statement === 'show') {
            return $this->sQuery->fetchAll($fetchmode);
        } elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
            return $this->sQuery->rowCount();
        } else {
            return NULL;
        }
    }
    
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function column($query, $params = null) {
        $this->Init($query, $params);
        $resultColumn = $this->sQuery->fetchAll(PDO::FETCH_COLUMN);
        $this->rowCount = $this->sQuery->rowCount();
        $this->columnCount = $this->sQuery->columnCount();
        $this->sQuery->closeCursor();
        return $resultColumn;
    }

    public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC) {
        $this->Init($query, $params);
        $resultRow = $this->sQuery->fetch($fetchmode);
        $this->rowCount = $this->sQuery->rowCount();
        $this->columnCount = $this->sQuery->columnCount();
        $this->sQuery->closeCursor();
        return $resultRow;
    }

    public function single($query, $params = null) {
        $this->Init($query, $params);
        return $this->sQuery->fetchColumn();
    }

    private function ExceptionLog($message, $sql = "") {
        $exception = 'Unhandled Exception. <br />';
        $exception .= $message;
        $exception .= "<br /> You can find the error back in the log.";

        if (!empty($sql)) {
            $message .= "\r\nRaw SQL : " . $sql;
        }
        $this->log->write($message, $this->DBName . md5($this->DBPassword));
        //Prevent search engines to crawl
        header("HTTP/1.1 500 Internal Server Error");
        header("Status: 500 Internal Server Error");
        return $exception;
    }

}
