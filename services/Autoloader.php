<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.03.2022
 * Time: 22:57
 */

namespace services;


class Autoloader
{
    function loadClass($classname)
    {
        $classname = str_replace("app\\", $_SERVER['DOCUMENT_ROOT']."/", $classname);
        $classname = str_replace("\\","/",$classname.".php");
        if (file_exists($classname)) {
            require $classname;
        }
    }
}