<?php
/**
 * Created by PhpStorm.
 * User: Wichny
 * Date: 23.02.2017
 * Time: 15:07
 */

function call($controller, $action) {
    require_once('controllers/' . $controller . 'Controller.php');

    switch($controller) {
        case 'about':
            $controller = new AboutController();
            break;

        case 'blog':
            require_once('models/blog.php');
            $controller = new BlogController();
            break;

        case 'admin':
            require_once('models/admin.php');
            $controller = new AdminController();
            break;
    }

    $controller->{ $action }();
}

$controllers = array('about' => ['index', 'error'],
                     'admin' => ['index', 'login', 'register', 'logout', 'error'],
                     'blog' => ['index', 'post', 'error']
);

if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        call($controller, 'index');
    }
} else {
    call('about', 'error');
}