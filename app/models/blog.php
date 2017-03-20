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

    public static function add($title, $content, $author_id) {


        $db = Db::getInstance();

        $sql = "INSERT INTO `posts` (`title`, `text`, `date`, `author_id`) VALUES (:title, :content, NOW(), :author)";
        $statement = $db->prepare($sql);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':author', $author_id);

        $inserted = $statement->execute();

        if($inserted){
            echo 'Dodano Post!<br>';
        }
    }

    public static function update($title, $content, $id) {


        $db = Db::getInstance();

        $sql = "UPDATE posts SET title = :title, text = :content WHERE id = :id";
        $statement = $db->prepare($sql);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':id', $id);

        $inserted = $statement->execute();

        if($inserted){
            echo 'Dodano Post!<br>';
        }
    }

    public static function paginate($page, $limit) {
        $db = Db::getInstance();

        $total = $db->query('SELECT COUNT(*) FROM posts')->fetchColumn();
        $pages = ceil($total / $limit);
        $offset = ($page - 1)  * $limit;

        $req = $db->prepare('SELECT * FROM posts ORDER BY date DESC LIMIT :limit OFFSET :offset');

        $req->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $req->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $req->execute();

        $posts = $req->fetchAll(PDO::FETCH_ASSOC);

        return $posts;

    }

    public static function amount()
    {
        $db = Db::getInstance();
        $total = $db->query('SELECT COUNT(*) FROM posts')->fetchColumn();

        return $total;
    }


    public static function delete($id)
    {
        $db = Db::getInstance();

        $req = $db->prepare('DELETE FROM posts WHERE id = :id');
        $req->bindValue(':id', (int)$id, PDO::PARAM_INT);

        $req->execute();
    }

}