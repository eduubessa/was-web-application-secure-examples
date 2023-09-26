<?php

namespace ItsPossible\Database;

use PDO;

class DB {

    private int $port = 3306;
    private string $hostname;
    private string $username;
    private string $password;
    private string $dbname;
    private string $prefix;
    private string $encode = "utf8mb4";

    private string $table;
    private string $query;

    private array $values = [];

    private PDO $connection;

    public function __construct()
    {

        // Set variables with value from config file
        $this->hostname = "localhost";
        $this->username = "root";
        $this->password = "RVQjJ6Hq24tdDA66";
        $this->dbname = "wasdev";
        $this->prefix = "";

        $this->openConnection();
    }

    private function openConnection(): void
    {
        try {

            $this->connection = new PDO("mysql:host={$this->hostname};port={$this->port};dbname={$this->dbname}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

        }catch(\Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function table(string $name): DB
    {
        $this->table = $name;
        return $this;
    }

    public function select(): DB
    {
        $this->query = "SELECT ";

        if(func_num_args() > 0)
        {
            foreach(func_get_args() as $index => $column)
            {
                $this->query .= ($index < (func_num_args()-1)) ? "{$column}, " : $column;
            }
        }else {
            $this->query .= "*";
        }

        $this->query .= " FROM {$this->table}";

        return $this;
    }

    public function where(): DB
    {
        try {
            if (str_contains($this->query, "SELECT")) {
                $this->query .= (str_contains($this->query, "WHERE")) ? " AND " : " WHERE ";

                if (func_num_args() >= 2) {
                    $this->query .= func_get_args()[0];
                    if (func_num_args() == 2) {
                        $this->values = array_merge($this->values, [func_get_args()[0] => func_get_args()[1]]);
                        $this->query .= (is_int(func_get_args()[0]) or is_bool(func_get_args()[0])) ? " = :" . func_get_args()[0] : " LIKE :" . func_get_args()[0];
                    } else if (func_num_args() == 3) {
                        $this->values = array_merge($this->values, [func_get_args()[0] => func_get_args()[2]]);
                        $this->query .= (is_int(func_get_args()[2]) or is_bool(func_get_args()[2])) ? " = :" . func_get_args()[0]  : " LIKE :" . func_get_args()[0];
                    }
                } else {
                    throw new \Exception("Syntax error");
                }


            }
        }catch(\Exception $e){
            echo $e->getMessage();
        }

        return $this;
    }

    public function get(): array|false
    {
        $stmt = $this->connection->prepare($this->query);

        foreach($this->values as $col => $val){
            $stmt->bindValue(":{$col}", $val);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert(array $data): void
    {
        $this->query = "INSERT INTO {$this->table} (";

        $i = 0;
        foreach($data as $col => $val)
        {
            $i++;
            $this->query .= (count($data) > $i) ? "{$col}, " : $col;
        }

        $this->query .= ") VALUES (";

        $i = 0;
        foreach($data as $col => $val)
        {
            $i++;
            $this->query .= (count($data) > $i) ? ":{$col}, " : ":{$col}";
        }

        $this->query .= ");";


        $stmt = $this->connection->prepare($this->query);

        foreach($data as $col => $val)
        {
            $stmt->bindValue(":{$col}", $val);
        }

        $stmt->execute();
    }

}

