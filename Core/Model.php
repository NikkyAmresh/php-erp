<?php
namespace Core;

require_once 'MysqliDb.php';

use App\Config;

abstract class Model
{

    protected static $table = '';
    protected static $tableJOIN = '';
    protected $_data = [];
    protected $dbCall = null;

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
            $this->dbCall = $this->db;
            if (isset($cond[0])) {
                foreach ($cond as $condition) {
                    $this->dbCall = $this->dbCall->where($condition['field'], $condition['value']);
                }
            } else {
                $this->dbCall = $this->dbCall->where($cond['field'], $cond['value'])->orderBy("id", "asc");
            }
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
        if (!count($this->_data)) {
            return $this->dbCall->getWithJoin(static::$tableJOIN, $this->numRows, $this->orderBy);
        }
        return $this->_data;
    }

    public function delete()
    {
        return $this->db->where("id", $this->id)->delete(static::$table);

    }

    public function getWithJoin()
    {
        if ($this->cond) {
            return $this->dbCall->getWithJoin(static::$tableJOIN, $this->numRows, $this->orderBy);
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
        $dataToInsert = $this->_data;
        $columns = array_column($this->getTableStructure(), 'Field');
        foreach (array_keys($dataToInsert) as $key) {
            if (!(in_array($key, $columns))) {
                unset($dataToInsert[$key]);
            }
        }
        if (isset($this->_data['id'])) {
            return $this->db->where('id', $this->_data['id'])->update(static::$table, $dataToInsert);
        }
        return $this->db->insert(static::$table, $dataToInsert);
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

    public function runQuery($query)
    {
        return $this->db->query($query);
    }

    public function getTableStructure()
    {
        return $this->db->query('DESC ' . static::$table);
    }
}