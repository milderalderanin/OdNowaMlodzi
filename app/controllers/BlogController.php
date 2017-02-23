<?php
/**
 * Created by PhpStorm.
 * User: Wichny
 * Date: 23.02.2017
 * Time: 23:22
 */

class BlogController
{

    public function index()
    {
        require_once ('views/blog/index.phtml');
    }

    public function post()
    {
        require_once ('views/blog/post.phtml');
    }

    public function error()
    {
        require_once ('views/blog/error.php');
    }
}