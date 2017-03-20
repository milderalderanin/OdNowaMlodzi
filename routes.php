<?php
/**
 * Created by PhpStorm.
 * User: Wichny
 * Date: 23.02.2017
 * Time: 15:07
 */

function call($controller, $action) {
    require_once('../app/controllers/' . $controller . 'Controller.php');

    switch($controller) {
        case 'about':
            $controller = new AboutController();
            break;

        case 'blog':
            require_once('../app/models/blog.php');
            require_once('../app/models/admin.php');
            $controller = new BlogController();
            break;

        case 'admin':
            require_once('../app/models/admin.php');
            $controller = new AdminController();
            break;

        case 'gallery':
            require_once('../app/models/gallery.phtml');
            require_once('../app/models/image.php');
            $controller = new GalleryController();
            break;
    }

    $controller->{ $action }();
}

$controllers = array('about' => ['index', 'error'],
                     'admin' => ['index', 'login', 'register', 'logout', 'error'],
                     'blog' => ['index', 'post', 'error'],
                     'gallery' => ['index']
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