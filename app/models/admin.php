<?php
/**
 * Created by PhpStorm.
 * User: Wichny
 * Date: 24.02.2017
 * Time: 00:14
 */

class Admin {

    public $id;
    public $login;
    public $password;

    public function __construct($id, $login, $password) {
        $this->$id           = $id;
        $this->$login       = $login;
        $this->$password    = $password;
    }

    public static function all() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM users');

        foreach($req->fetchAll() as $post) {
            $list[] = new Admin($post['id'], $post['login'], $post['password']);
        }

        return $list;
    }

    public static function find($login) {
        $db = Db::getInstance();

        $req = $db->prepare('SELECT * FROM users WHERE login = :login');

        $req->execute(array('login' => $login));
        $user = $req->fetch();

        return $user;
    }

    public static function add($login, $password) {

        $password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 8]);

        $db = Db::getInstance();

        $sql = "INSERT INTO `users` (`login`, `password`) VALUES (:log, :pass)";
        $statement = $db->prepare($sql);

        $statement->bindValue(':log', $login);
        $statement->bindValue(':pass', $password);

        $inserted = $statement->execute();

        if($inserted){
            echo 'Row inserted!<br>';
        }
    }

}