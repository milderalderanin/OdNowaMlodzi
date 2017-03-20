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


        require_once ('../app/views/admin/layout.phtml');

    }

    public function gallery()
    {
        if($_SESSION["login"] == "Guest" || !isset($_SESSION["login"]))
            return require_once ('../app/views/admin/login.phtml');

        require_once ('../app/views/admin/layout.phtml');
    }

    public function accountsettings()
    {
        if($_SESSION["login"] == "Guest" || !isset($_SESSION["login"]))
            return require_once ('../app/views/admin/login.phtml');

        require_once ('../app/views/admin/layout.phtml');
    }

    public function posts()
    {

        if($_SESSION["login"] == "Guest" || !isset($_SESSION["login"]))
            return require_once ('../app/views/admin/login.phtml');

        empty($_GET['var']) ? $page = 1 : $page = $_GET['var'];
        $posts = Post::paginate($page, 10);
        $total = Post::amount();
        $pages = ((int)$total/10);

        if($pages > $page) $right = true; else $right = false;
        if($page > 1) $left = true; else $left = false;

        foreach($posts as $post)
        {
            $users[$post['author_id']] = Admin::findId($post['author_id'])['login'];
        }


        require_once ('../app/views/admin/layout.phtml');
    }

    public function users()
    {
        if($_SESSION["login"] == "Guest" || !isset($_SESSION["login"]))
            return require_once ('../app/views/admin/login.phtml');

        require_once ('../app/views/admin/layout.phtml');
    }



    public function login()
    {
        $login = $_POST["login"];
        $password = $_POST["password"];

        $user = Admin::findLogin($login);

        if(password_verify($password, $user['password']))
        {
            $_SESSION["login"] = $login;
            $_SESSION["id"] = $user['id'];
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

    public function addPost()
    {
        if($_SESSION["login"] == "Guest" || !isset($_SESSION["login"]))
            return require_once ('../app/views/admin/login.phtml');

        $title = $_POST['title'];
        $content = $_POST['content'];
        $author_id = $_SESSION['id'];

        Post::add($title, $content, $author_id);

        header("Location: /admin/posts");
    }

    public function deletePost()
    {
        if($_SESSION["login"] == "Guest" || !isset($_SESSION["login"]))
            return require_once ('../app/views/admin/login.phtml');

        $id = $_GET['var'];
        $page = $_GET['page'];

        Post::delete($id);

        header("Location: /admin/posts/" . $page);
    }


    public function editPost()
    {
        if($_SESSION["login"] == "Guest" || !isset($_SESSION["login"]))
            return require_once ('../app/views/admin/login.phtml');

        if(empty($_POST['content']) || empty($_POST['title'])) {
            $id = $_GET['var'];
            $page = $_GET['page'];


            $post = Post::find($id);

            $user = Admin::findId($post['author_id']);

            require_once('../app/views/admin/layout.phtml');
        } else {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $id = $_POST['id'];

            Post::update($title, $content, $id);

            header("Location: /admin/posts/");

        }
    }

    public function error()
    {
        require_once ('../app/views/admin/error.php');
    }
}