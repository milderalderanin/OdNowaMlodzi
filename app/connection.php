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
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instance = new PDO('mysql:host=localhost;dbname=odnowa', 'root', '', $pdo_options);
        }
        return self::$instance;
    }
}