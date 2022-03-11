<?php

require  $_SERVER['DOCUMENT_ROOT']."/services/App.php";

$controller = (new \controllers\Controller())->run();
