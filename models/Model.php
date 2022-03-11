<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.03.2022
 * Time: 23:54
 */

namespace models;


class Model
{
    protected static $table;
    protected static $fields = [];
    protected $primaryKey = 'id';
    protected $attributes = [];
    protected $isLoad = false;


    public function __construct()
    {
        if (empty(static::$table)) {
            throw new \Exception('Не определили таблицу в:' . get_class($this));
        }

        if(empty(static::$fields)) {
            throw new \Exception('Не определили поля таблицы в:' . get_class($this));
        }
    }

    public function prepareAttributes(array $data)
    {

    }

    protected function bindParams(\PDOStatement $query)
    {

    }

    public function save()
    {

    }

    protected function updateCategory(){

    }

    protected function insert()
    {

    }
}