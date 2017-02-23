<?php
/**
 * Created by PhpStorm.
 * User: Wichny
 * Date: 23.02.2017
 * Time: 15:04
 */

session_start();
if(!isset($_SESSION["login"])) $_SESSION["login"] = "Guest";

require_once('connection.php');

if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
} else {
    $controller = 'about';
    $action     = 'index';
}

if (isset($_GET['action'])) {
    $action     = $_GET['action'];
} else $action     = 'index';


require_once('views/layout.php');