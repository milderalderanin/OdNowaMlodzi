<?php
/**
 * Created by PhpStorm.
 * User: Wichny
 * Date: 23.02.2017
 * Time: 14:58
 */

class Db
{
    private static $instance = NULL;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $config = parse_ini_file("../app/configuration.ini", true);
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instance = new PDO('mysql:host='.$config['database']['host'].';dbname='.$config['database']['name'], $config['database']['user'], $config['database']['password'], $pdo_options);
            self::$instance->exec("set names utf8;");
        }
        return self::$instance;
    }
}