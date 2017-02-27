<?php
/**
 * Created by PhpStorm.
 * User: Wichny
 * Date: 24.02.2017
 * Time: 00:12
 */

class AdminController
{

    public function index()
    {
        if($_SESSION["login"] == "Guest" || !isset($_SESSION["login"]))
            return require_once ('../app/views/admin/login.phtml');

        $login = $_SESSION["login"];


        require_once ('../app/views/admin/index.phtml');

    }

    public function login()
    {
        $login = $_POST["login"];
        $password = $_POST["password"];

        $user = Admin::findLogin($login);

        if(password_verify($password, $user['password']))
        {
            $_SESSION["login"] = $login;
        }

        header("Location: /admin");
        exit();
    }

    public function register()
    {
        $login = $_POST["login"];
        $password = $_POST["password"];

        Admin::add($login, $password);
    }

    public function logout()
    {
        $_SESSION["login"] = "Guest";
        header("Location: /");
        exit();
    }

    public function error()
    {
        require_once ('../app/views/admin/error.php');
    }
}