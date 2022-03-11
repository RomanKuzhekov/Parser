<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.03.2022
 * Time: 23:21
 */

namespace controllers;

class Controller
{
    protected $config;
    private $action;
    private $defaultAction = "Index";
    private $category;
    private $category_id;
    private $categories;
    private $products;
    private $message;
    private $params;
    private $patterns = ["#[/]?(?P<action>\w+)?[/]?[?]?(?P<params>.*)#ui"];

    public function __construct()
    {
        $this->config = require "./config/config.php";

        $this->parseRequest();
    }

    public function run($action = null)
    {
        $this->action = $this->action ?: $this->defaultAction;
        $action = "action".$this->action;
        return $this->$action();
    }

    public function actionIndex()
    {
        $this->prepareCategory();
        $this->prepareProduct();


    }

    public function actionProduct()
    {

    }

    private function parseRequest()
    {
        foreach ($this->patterns as $pattern) {
            if(preg_match_all($pattern, $_SERVER['REQUEST_URI'], $matches)){
                $this->action = ucfirst($matches['action'][0]);
                $this->params = $matches['params'][0];
                return;
            }
        }
    }

    public function render($template, $params)
    {

    }

    public function renderTemplate($template, $params)
    {

    }

    private function prepareCategory()
    {

    }

    private function prepareProduct()
    {

    }

    public function redirect($url)
    {
        header("Location: /$url");
    }

    public function getPage(string $url)
    {

    }

    public function prepareVar($var)
    {
        $var = trim(strip_tags($var));
        return empty($var) ? 'Нет значения' : $var;
    }
}