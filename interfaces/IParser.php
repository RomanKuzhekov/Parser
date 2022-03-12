<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 12.03.2022
 * Time: 0:03
 */

namespace interfaces;


interface IParser
{
    public function getPage(string $url);
}