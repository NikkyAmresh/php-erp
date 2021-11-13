<?php
namespace Core;

require_once 'MysqliDb.php';

use App\Config;

/**
 * Base model
 *
 * PHP version 7.0
 */
abstract class Model
{

    protected static $table = '';

    public function __construct()
    {
        $db = new \MysqliDb(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);
        $this->db = $db;
    }

    public function getAll()
    {
        return $this->db->orderBy("id","asc")->get(static::$table);
    }

    public function get($id)
    {
        return $this->db->where("id", $id)->getOne(static::$table);

    }

    public function delete($id)
    {
        return $this->db->where("id", $id)->delete(static::$table);

    }

    // public static function delete($id)
    // {
    //     $db = static::getDB();
    //     $stmt = $db->prepare('delete FROM ' . static::$table . ' where id=?');
    //     $stmt->bind_param('s', $id);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     return mysqli_fetch_array($result);
    // }

    // public static function update($id, $data)
    // {
    //     $db = static::getDB();
    //     $stmt = $db->prepare('delete FROM ' . static::$table . ' where id=?');
    //     $stmt->bind_param('s', $id);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     return mysqli_fetch_array($result);
    // }

}
