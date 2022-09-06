<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.03.2022
 * Time: 23:21
 */

namespace controllers;

use interfaces\IParser;
use models\Category;
use models\Product;


class Controller implements IParser
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

        echo $this->render("parser/index",
            [
                'category' => $this->category,
                'message' => $this->message,
                'products' => $this->products,
            ]
        );
    }

    public function actionProduct()
    {
        $this->prepareCategory();
        $this->products = Product::getProductsByCategory($this->params);
        $category = Category::getCategory($this->params);
        echo $this->render("parser/category",
            [
                'category' => $category->title,
                'products' => $this->products
            ]
        );
    }

    private function parseRequest()
    {
        foreach ($this->patterns as $pattern) {
            if (preg_match_all($pattern, $_SERVER['REQUEST_URI'], $matches)) {
                $this->action = ucfirst($matches['action'][0]);
                $this->params = $matches['params'][0];
                return;
            }
        }
    }

    public function render($template, $params)
    {
        return $this->renderTemplate("layouts/main",
            [
                'content' => $this->renderTemplate($template, $params),
                'categories' => $this->categories,
            ]
        );
    }

    public function renderTemplate($template, $params)
    {
        extract($params);
        ob_start();
        $templatePath = $this->config['root_dir'] . "views/{$template}.php";
        include $templatePath;
        return ob_get_clean();
    }

    private function prepareCategory()
    {
        //выбираем рандомную категорию из БД для парсинга
        $this->category = Category::getRandomCategory();

        //заносим все категории в БД 1 раз
        if ($this->category === false) {
            (new ParserController())->parseCategories();
            $this->redirect('index.php');
        }
        $this->categories = Category::getAllCategory();
    }

    private function prepareProduct()
    {
        $this->products = Product::getProductsByCategory($this->category->category_id);

        //если нет товаров в бд - парсим товары по новой категории и заносим их в $products
        if (!$this->products) {
            $this->message = (new ParserController())->parseProducts($this->category);
            $this->products = Product::getProductsByCategory($this->category->category_id);
        }
    }

    public function redirect($url)
    {
        header("Location: /$url");
    }

    public function getPage(string $url)
    {
        $content = file_get_contents($url);
        $dom = new \DOMDocument();
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'utf-8');
        @$dom->loadHTML($content);
        return new \DOMXPath($dom);
    }

    public function prepareVar($var)
    {
        return empty(trim(strip_tags($var))) ? 'Нет значения' : trim($var);
    }
}