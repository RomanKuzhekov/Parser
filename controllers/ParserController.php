<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.03.2022
 * Time: 23:22
 */

namespace controllers;


/**
 * Class ParserController
 * @package controllers
 */
final class ParserController extends Controller
{
    private $url;
    protected $config;
    private $count = 0;

    /**
     * ParserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->url = $this->config['url'];

        if(empty($this->url)){
            throw new \Exception("Адрес сайта пустой.");
        }
    }

    public function parseCategories()
    {

    }

    public function parseProducts($categories) : string
    {

    }
}