<?php

class Image {

    public $id;
    public $url;

    public function __construct($id, $url) {
        $this->id      = $id;
        $this->url     = $url;
    }

    public static function paginate($page, $limit, $id) {
        $db = Db::getInstance();

        $total = $db->query('SELECT COUNT(*) FROM image')->fetchColumn();
        $pages = ceil($total / $limit);
        $offset = ($page - 1)  * $limit;

        $req = $db->prepare('SELECT * FROM image WHERE gallery_id = :id LIMIT :limit OFFSET :offset');

        $req->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $req->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $req->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $req->execute();

        $posts = $req->fetchAll(PDO::FETCH_ASSOC);

        return $posts;
    }


}