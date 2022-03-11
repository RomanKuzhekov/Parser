<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 12.03.2022
 * Time: 0:00
 */

namespace traits;


trait Singleton
{
    private static $instance = null;

    private function __construct(){}
    private function __clone(){}

    /**
     * @return static
     */
    public static function getInstance()
    {
        if(is_null(static::$instance)){
            static::$instance = new static();
        }
        return static::$instance;
    }
}