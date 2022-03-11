<?php
require_once $_SERVER['DOCUMENT_ROOT']."/services/Autoloader.php";
spl_autoload_register([new \services\Autoloader(), "loadClass"]);