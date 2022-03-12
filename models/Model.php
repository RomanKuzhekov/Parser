<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.03.2022
 * Time: 23:54
 */

namespace models;


use services\Db;

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
        foreach ($data as $key => $val){
            if (in_array($key, static::$fields)) {
                $this->attributes[$key] = $val;
            }
        }
    }

    protected function bindParams(\PDOStatement $query)
    {
        foreach ($this->attributes as $key => $value){
            $query->bindValue(":$key", $value);
        }
        return $query;
    }

    public function save()
    {
        if ($this->isLoad){
            $this->updateCategory();
        }
        $this->insert();
    }

    protected function updateCategory(){
        Db::getInstance()->db()->query('Update ' . Category::$table . ' SET flag=1 WHERE category_id =' . $this->attributes['category_id'])->execute();
    }

    protected function insert()
    {
        $columns = array_keys($this->attributes);
        if(!empty($this->attributes)){
            $query = Db::getInstance()->db()->prepare('INSERT INTO ' . static::$table . '(' . implode(', ', $columns) . ') VALUES (:' . implode(', :', $columns).')');
            $query = $this->bindParams($query);
            $query->execute();
        }
    }
}