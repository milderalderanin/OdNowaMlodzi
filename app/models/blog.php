<?php
/**
 * Created by PhpStorm.
 * User: Wichny
 * Date: 23.02.2017
 * Time: 15:14
 */

class Post {

    public $id;
    public $author;
    public $content;

    public function __construct($id, $author, $content) {
        $this->id      = $id;
        $this->author  = $author;
        $this->content = $content;
    }

    public static function all() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM posts');

        foreach($req->fetchAll() as $post) {
            $list[] = new Post($post['id'], $post['author'], $post['content']);
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

    public static function paginate($page, $limit) {
        $db = Db::getInstance();

        $total = $db->query('SELECT COUNT(*) FROM posts')->fetchColumn();
        $pages = ceil($total / $limit);
        $offset = ($page - 1)  * $limit;

        $req = $db->prepare('SELECT * FROM posts ORDER BY date LIMIT :limit OFFSET :offset');

        $req->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $req->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $req->execute();

        $posts = $req->fetchAll(PDO::FETCH_ASSOC);

        return $posts;




    }
}