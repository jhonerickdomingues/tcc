<?php

class QueryBuilder
{
    public $pdo;
    private $statement;
    private $status;
    private $lastId;
    private $sql = [];
    private $where = [];
    private $inner = [];
    private $error = [];

    public function __construct($obj)
    {
        $this->pdo = $obj;
    }

    public function query($sql)
    {
        $this->statement = $this->pdo->prepare($sql);

        $this->status = $this->statement->execute();
        $this->error = $this->statement->errorInfo();
        $this->lastId = $this->pdo->lastInsertId();
        return $this;
    }

    public function count()
    {
        return $this->statement->rowCount();
    }

    public function status()
    {
        if($this->status){
            return true;
        }else{
            return false;
        }
    }

    public function error()
    {
        return $this->error;
    }

    public function lastId()
    {
        return $this->lastId;
    }

    public function listData()
    {
        return $this->statement->fetchAll(PDO::FETCH_CLASS);
    }

}
