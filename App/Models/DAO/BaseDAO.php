<?php

namespace App\Models\DAO;

use App\Lib\Conexao;
use Exception;
use PDOException;

abstract class BaseDAO
{

    private $table;
    private $connection;

    public function __construct($table)
    {
        $this->table = $table;
        $this->connection = Conexao::getConnection();
    }

    private function execute($query, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $exc) {
            throw new Exception('Erro ao executar a query: ' . $exc->getMessage(), 401);
        }
    }

    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        $where = (isset($where)) ? " WHERE {$where}" : "";
        $order = (isset($order)) ? " ORDER BY {$order}" : "";
        $limit = (isset($limit)) ? " LIMIT {$limit}" : "";
        
        $query = "SELECT {$fields} FROM {$this->table} {$where} {$order} {$limit}";
        //echo '<br><br>' . $query;
        return $this->execute($query);

    }

    public function insert($values)
    {
        if(!empty($values)){
            $fields = array_keys($values);
            $binds = array_pad([], count($fields), '?');
            
            $query = "INSERT INTO {$this->table} (" . implode(',', $fields) . ") VALUES (" . implode(',', $binds) . ")";
            $stmt = $this->execute($query, array_values($values));
            
           return $stmt->rowCount();
        } else {           
            return false;
        }
    }

    public function update($where, $values)
    {
        if(!empty($where) && !empty($values)){
            $fields = array_keys($values);

            $query = "UPDATE {$this->table} SET " . implode(' = ? ', $fields) . " = ? WHERE {$where}";
            $stmt = $this->execute($query, array_values($values));

            return $stmt->rowCount();
        }else {
            return false;
        }
    }

    public function delete($where)
    {
        $query = "DELETE FROM {$this->table} WHERE {$where}";
        return $this->execute($query);
    }
    
}