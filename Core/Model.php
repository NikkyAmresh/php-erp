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
        $db = new \MysqliDb(Config::getDbHost(), Config::getDbUser(), Config::getDbPassword(), Config::getDbName());
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

    public function getAll($numRows = null)
    {
        return $this->db->orderBy("id", "asc")->get(static::$table, $numRows);
    }

    public function get($id = null, $cond = null)
    {
        $data = null;
        if ($id) {
            $data = $this->db->where("id", $id)->getOne(static::$table);
        } elseif ($cond) {
            $data = $this->db->where($cond['field'], $cond['value'])->getOne(static::$table);
        }
        $this->setData($data);
        return $this->_data;

    }

    public function delete($id)
    {
        return $this->db->where("id", $id)->delete(static::$table);

    }

    public function getWithJoin($numRows = null, $id = null, $cond = null, $orderBy = null)
    {
        if ($cond) {
            return $this->db->where(static::$table . ".{$cond['field']}", $cond['value'])->getWithJoin(static::$tableJOIN, $numRows, $orderBy);
        }
        if (!static::$tableJOIN) {
            return $this->db->getWithJoin("SELECT * FROM " . static::$table, $numRows, $orderBy);
        }
        if ($id) {
            return $this->db->where(static::$table . '.id', $id)->getWithJoin(static::$tableJOIN, $numRows, $orderBy);
        }
        return $this->db->getWithJoin(static::$tableJOIN, $numRows, $orderBy);
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

    public function getError()
    {
        return $this->db->getLastError();
    }

}
