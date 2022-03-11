<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.03.2022
 * Time: 23:55
 */

namespace models;


use services\Db;

final class Product extends Model
{
    protected static $table = 'products';
    protected static $fields = [
        'id',
        'category_id',
        'title',
        'url',
        'price',
        'img'
    ];
    protected $isLoad = true;

    public static function getProductsByCategory($categoryId)
    {
        $query = Db::getInstance()->db()->prepare('SELECT * FROM ' . static::$table . ' WHERE category_id = :category_id');
        $query->bindValue(":category_id", $categoryId);
        $query->execute();
        return $query->fetchAll(Db::FETCH_CLASS, self::class);
    }
}