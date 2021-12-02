<?php
namespace Core;

require_once 'MysqliDb.php';

use App\Config;

abstract class Model
{

    protected static $table = '';
    protected static $tableJOIN = '';
    protected $_data = [];

    public function initDb()
    {
        $this->db = new \MysqliDb(Config::getDbHost(), Config::getDbUser(), Config::getDbPassword(), Config::getDbName());
    }

    public function __construct($id = null, $cond = null, $orderBy = null, $numRows = null)
    {
        $this->id = $id;
        $this->cond = $cond;
        $this->orderBy = $orderBy;
        $this->numRows = $numRows;
        if (!static::$tableJOIN) {
            self::$tableJOIN = "SELECT * FROM " . static::$table;
        }
        $this->initDb();
        if ($id) {
            $this->getOneWithJoin();
        } elseif ($cond) {
            $data = $this->db->where($cond['field'], $cond['value'])->orderBy("id", "asc")->get(static::$table);
            $this->setData($data);
        }

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
        } else {
            $func($params);
        }
    }

    public function getAll($numRows = null)
    {
        return $this->db->orderBy("id", "asc")->get(static::$table, $numRows);
    }

    public function get()
    {
        return $this->_data;
    }

    public function delete()
    {
        return $this->db->where("id", $this->id)->delete(static::$table);

    }

    public function getWithJoin()
    {
        if ($this->cond) {
            return $this->db->where(static::$table . ".{$this->cond['field']}", $this->cond['value'])->getWithJoin(static::$tableJOIN, $this->numRows, $this->orderBy);
        }
        if (!static::$tableJOIN) {
            return $this->db->getWithJoin("SELECT * FROM " . static::$table, $this->numRows, $this->orderBy);
        }
        if ($this->id) {
            return $this->db->where(static::$table . '.id', $this->id)->getWithJoin(static::$tableJOIN, $this->numRows, $this->orderBy);
        }
        return $this->db->getWithJoin(static::$tableJOIN, $this->numRows, $this->orderBy);
    }

    public function getOneWithJoin()
    {
        $data = $this->db->where(static::$table . '.id', $this->id)->getWithJoin(static::$tableJOIN);
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

    public function deleteMany($cond, $numRows = null)
    {
        $this->db->where(static::$table . ".{$cond['field']}", $cond['value'])->delete(static::$table, $numRows);
    }

    public function insertMulti($dataArray)
    {
        $this->db->insertMulti(static::$table, $dataArray);
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
