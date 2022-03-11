<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.03.2022
 * Time: 23:55
 */

namespace models;


final class Category extends Model
{
    protected static $table = 'categories';
    protected static $fields = [
        'category_id',
        'title',
        'url',
        'flag'
    ];
    protected $primaryKey = 'category_id';

    public static function getRandomCategory()
    {

    }

    public static function getAllCategory()
    {

    }
}