<?php
namespace Core;

require_once 'MysqliDb.php';

use App\Config;
use \MysqliDb;

abstract class Model
{

    protected $table = '';
    protected $tableJOIN = '';
    protected $_data = [];
    protected $dbCall = null;
    protected $dbModel;

    public function __construct(MysqliDb $dbModel)
    {
        $this->dbModel = $dbModel;
    }

    public function initDb()
    {
        $this->db = $this->dbModel->setConfig(Config::getEnv('DB_HOST'), Config::getEnv('DB_USER'), Config::getEnv('DB_PASSWORD'), Config::getEnv('DB_NAME'));
    }

    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    public function bind($id = null, $cond = null, $orderBy = null, $page = 1)
    {
        $this->id = $id;
        $this->cond = $cond;
        $this->orderBy = $orderBy;
        $this->page = $page;
        if (!$this->tableJOIN) {
            $this->tableJOIN = "SELECT * FROM " . $this->table;
        }
        $this->initDb();
        if ($id) {
            $this->get();
        } elseif ($cond) {
            $this->dbCall = $this->db;
            foreach ($cond as $field => $value) {
                $this->dbCall = $this->dbCall->where($field, $value)->orderBy("id", "asc");
            }
        }
        return $this;
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

    public function getAll($page = null)
    {
        return $this->db->orderBy("id", "asc")->get($this->table, $page);
    }

    public function getResult()
    {
        if (!count($this->_data)) {
            return $this->dbCall->getWithJoin($this->tableJOIN, $this->page, $this->orderBy);
        }
        return $this->_data;
    }

    public function delete()
    {
        return $this->db->where("id", $this->id)->delete($this->table);

    }

    public function getCollection()
    {
        if ($this->id) {
            return $this->db->where($this->table . '.id', $this->id)->getWithJoin($this->tableJOIN, $this->page, $this->orderBy);
        }
        return $this->db->getWithJoin($this->tableJOIN, $this->page, $this->orderBy);
    }

    public function get()
    {
        $data = [];
        if ($this->id) {
            $data = $this->db->where($this->table . '.id', $this->id)->getWithJoin($this->tableJOIN);
        } else {
            $data = $this->db->getWithJoin($this->tableJOIN, $this->page, $this->orderBy);
        }
        if (!isset($data[0])) {
            return null;
        }
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
            return $this->db->where('id', $this->_data['id'])->update($this->table, $dataToInsert);
        }
        return $this->db->insert($this->table, $dataToInsert);
    }

    public function deleteMany($cond, $numRows = null)
    {
        $this->dbCall = $this->db;
        foreach ($cond as $field => $value) {
            $this->dbCall = $this->dbCall->where($field, $value);
        }
        return $this->dbCall->delete($this->table, $numRows);
    }

    public function insertMulti($dataArray)
    {
        return $this->db->insertMulti($this->table, $dataArray);
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

    public function getPaginationSummary()
    {
        return $this->db->resultData;
    }

    public function getTableStructure()
    {
        return $this->db->query('DESC ' . $this->table);
    }
}
