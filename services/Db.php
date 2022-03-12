<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.03.2022
 * Time: 23:59
 */

namespace services;

use traits\Singleton;

final class Db extends \PDO
{
    use Singleton;

    private $conn = null;
    private $config;

    public function __construct()
    {
        $this->config = require "./config/config.php";
    }

    public function db()
    {
        if (is_null($this->conn)) {
            try {
                $this->conn = new \PDO(
                    $this->prepareDsnString(),
                    $this->config['db']['login'],
                    $this->config['db']['password']
                );
            } catch (\Exception $e){
                exit("Нет подключения к базе");
            }

            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return $this->conn;
    }

    private function prepareDsnString()
    {
        return sprintf("%s:host=%s;dbname=%s;charset=%s",
            $this->config['db']['driver'],
            $this->config['db']['host'],
            $this->config['db']['database'],
            $this->config['db']['charset']
        );
    }
}