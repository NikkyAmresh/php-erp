<?php
namespace Core;

require_once 'MysqliDb.php';

use App\Config;

abstract class Model
{

    protected static $table = '';
    protected static $tableJOIN = '';
    protected $_data = array();

    public function __construct()
    {
        $db = new \MysqliDb(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);
        $this->db = $db;
    }

    public function __call($func, $params)
    {
        if (!function_exists($func)) {
            $field = substr($func, 3);
            if (substr($func, 0, 3) === "get") {
                return $this->_data[lcfirst($field)];
            } elseif (substr($func, 0, 3) === "set") {
                $this->_data[lcfirst($field)] = $params[0];
                return $this;
            }
        }
    }

    public function getAll()
    {
        return $this->db->orderBy("id", "asc")->get(static::$table);
    }

    public function get($id)
    {
        $data = $this->db->where("id", $id)->getOne(static::$table);
        $this->setData($data);
        return $this->_data;

    }

    public function delete($id)
    {
        return $this->db->where("id", $id)->delete(static::$table);

    }

    public function getWithJoin($numRows = null, $id = null, $cond = null)
    {
        if ($cond) {
            return $this->db->where(static::$table . ".{$cond['field']}", $cond['value'])->getWithJoin(static::$tableJOIN, $numRows);
        }
        if (!static::$tableJOIN) {
            return $this->db->getWithJoin("SELECT * FROM " . static::$table, $numRows);
        }
        if ($id) {
            return $this->db->where(static::$table . '.id', $id)->getWithJoin(static::$tableJOIN, $numRows);
        }
        return $this->db->getWithJoin(static::$tableJOIN, $numRows);
    }

    public function getOneWithJoin($id)
    {
        $data = $this->db->where(static::$table . '.id', $id)->getWithJoin(static::$tableJOIN);
        $this->setData($data[0]);
        return $this->_data;

    }

    public function save()
    {
        if (isset($this->_data['id'])) {
            return $this->db->where('id', $this->_data['id'])->update(static::$table, $this->_data);
        }
        return $this->db->insert(static::$table, $this->_data);
    }

    public function setData($data)
    {
        return $this->_data = $data;
    }

}
