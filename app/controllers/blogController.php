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
        $posts = Post::paginate(1,5);
        foreach($posts as $post)
        {
            $users[$post['author_id']] = Admin::findId($post['author_id'])['login'];
        }
        require_once ('../app/views/blog/index.phtml');
    }

    public function post()
    {
        if(!isset($_GET['var']))
        {
            return self::error();
        }
        $post = Post::find($_GET['var']);
        if(empty($post))
        {
            return self::error();
        }
        $user = Admin::findId($post['author_id']);

        require_once ('../app/views/blog/post.phtml');
    }


    public function error()
    {
        require_once ('../app/views/blog/error.php');
    }
}