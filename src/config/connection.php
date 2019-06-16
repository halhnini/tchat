<?php
namespace Config;

Class Connection
{
    const HOST = 'localhost';
    const DB = 'tChat';
    const USER = 'root';
    const PASS = '';
    const CHARSET = 'utf8mb4';
    private static $_instance;

    private static $options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    /**
     * @return \PDO
     */
    public static function getInstance() {
        if (!isset(self::$_instance)) {
            try {
                self::$_instance = new \PDO('mysql:host='.self::HOST.';dbname='.self::DB.';charset='.self::CHARSET, self::USER, self::PASS, self::$options);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$_instance;
    }
}