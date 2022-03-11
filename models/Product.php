<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.03.2022
 * Time: 23:55
 */

namespace models;


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

    }
}