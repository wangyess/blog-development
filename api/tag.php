<?php
session_start();
require_once(__DIR__ . '/./Model.php');

class Tag extends Model
{
    public $pdo;
    public $table = 'tag';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($rows)
    {
        $data = $this->_add($rows);
        return $data['success'] ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    public function update($rows)
    {
        $data = $this->_update($rows);
        return $data['success'] ? ['success' => true] : ['success' => false, 'msg' => $data['msg']];
    }

    public function remove($rows)
    {
        $data = $this->_remove($rows);
        return $data;
    }

    public function read($rows)
    {
        $data = $this->_read($rows);
        return $data['success'] ? ['success' => true, 'data' => $data['data']] : ['success' => false, 'msg' => $data['msg']];
    }

    public function count()
    {
        $data = $this->read_count();
        return $data;
    }

    public function join_two($rows){
        $id = $rows['id'];
        $sql ="select * from tag INNER JOIN tag_article on tag.id = tag_article.tag_id where tag_article.article_id = $id";
        $sta=$this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }
    public function join_one($rows){
        $id = $rows['id'];
        $sql ="select * from article INNER JOIN tag_article on article.id = tag_article.article_id where tag_article.tag_id = $id";
        $sta=$this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }
}