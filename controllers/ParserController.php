<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.03.2022
 * Time: 23:22
 */

namespace controllers;

use models\Category;
use models\Product;


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
        $xpath = $this->getPage($this->url);

        // выбираем блоки с категориями <div class="b-header-menu__wrap">...</ul>
        $nav = $xpath->query("//div[contains(@class, 'b-header-menu__wrap')]");

        /** @var \DOMElement $item */
        //заходим внутрь каждого блока с категориями
        foreach ($nav as $item) {

            /** @var \DOMElement $link */
            //формируем ссылку для каждой категории
            foreach ($item->getElementsByTagName('a') as $link) {
                $data = [];
                $href = $link->getAttribute('href');

                //подчищаем ссылки
                if (strpos($href, '#') !== false || strpos($href, 'search') !== false || strpos($href, $this->url) !== false) {
                    continue;
                }

                $href = $this->url . $href;
                if ($link->textContent !== ''){
                    $data = [
                        'title' => $this->prepareVar($link->textContent),
                        'url' => $this->prepareVar($href),
                        'flag' => 0
                    ];
                }

                $category = new Category();
                $category->prepareAttributes($data);
                $category->save();
            }
        }
    }

    public function parseProducts($categories) : string
    {
        $xpath = $this->getPage($categories->url);

        // выбираем блоки с товарами <div class="catalog-products_list">...
        $nav = $xpath->query("//div[@class='catalog-products_list']");

        //если не находим товары - выбираем заново рандомную категорию и парсим её
        if ($nav->length !== 0) {
            /** @var \DOMElement $item */
            foreach ($nav as $item){
                if ($this->count < $this->config['countPars']) {
                    $link = $xpath->query(".//div/a[@class='product-info_name-container']", $item)->item(0);
                    $price = $xpath->query(".//div[contains(@class, 'product-price_current-price')]", $item)->item(0);
                   // $img = $xpath->query(".//img[contains(@class, 'b-product__photo')]", $item)->item(0)->getAttribute('src');

                    $data = [
                        'category_id' => $categories->category_id,
                        'title' => $this->prepareVar($link->textContent),
                        'url' => $this->url . $link->getAttribute('href'),
                        'price' => str_replace("₽", "", $this->prepareVar($price->textContent)),
                        'img' => "/assets/images/no-foto.jpg",
                    ];

                    $product = new Product();
                    $product->prepareAttributes($data);
                    $product->save();
                    $this->count++;
                }
            }
            $message = 'Количество товаров: ' . $this->count . 'шт.';
        } else {
            $message = 'Нет товаров по данной категории';
        }

        return $message;
    }
}