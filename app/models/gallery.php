<?php
/**
 * Created by PhpStorm.
 * User: Wichny
 * Date: 23.02.2017
 * Time: 15:14
 */

class Gallery {

    public $id;
    public $title;
    public $text;

    public function __construct($id, $title, $text) {
        $this->id      = $id;
        $this->title   = $title;
        $this->text    = $text;
    }

    public static function all() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM gallery');

        foreach($req->fetchAll() as $gal) {
            $list[] = new Gallery($gal['id'], $gal['title'], $gal['text']);
        }

        return $list;
    }


    public static function find($id) {
        $db = Db::getInstance();

        $req = $db->prepare('SELECT * FROM posts WHERE id = :id');

        $req->execute(array('id' => $id));
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