<?php
namespace App\Helpers\Models;

use Core\Model;

abstract class ModelHelper
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function delete($id)
    {
        $model = $this->model->bind($id);
        return $model->delete();
    }

    public function get($id)
    {
        $st = $this->model->bind($id);
        return $st->get();
    }

    public function getAll($conditions = null, $order = null, $page = 1)
    {
        return $this->model->bind(null, $conditions, $order, $page)->getCollection();
    }

}
