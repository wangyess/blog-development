<?php
session_start();

require_once(__DIR__ . '/./Model.php');

class Article extends Model
{
    public $pdo;
    public $table = 'article';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function read($rows)
    {
        $data = $this->_read($rows);
        return $data['success'] ? ['success' => true, 'data' => $data['data']] : ['success' => false, 'msg' => $data['msg']];
    }

    public function add($rows)
    {
        $data = $this->_add($rows);
        return $data['success'] ? ['success' => true,'data'=>$data['data']] : ['success' => false, 'msg' => 'internal_error'];
    }

    public function remove($rows)
    {
        $data = $this->_remove($rows);
        return $data;
    }

    public function update($rows)
    {
        $data = $this->_update($rows);
        return $data['success'] ? ['success' => true] : ['success' => false, 'msg' => $data['msg']];
    }

    public function count()
    {
        $data = $this->read_count();
        return $data;
    }

    //找到当前添加的数据
    public function find_id($title)
    {
        $sql = "select * from article where title= '{$title}'";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetch(PDO::FETCH_ASSOC);
    }
    //给标签添加数据
    public function tag_article_biao($data)
    {
        //拿到刚加入数据的ID
        $id = $data['id'];
        $str = $data['data'];
        //开始插入数据
        $test = '';
        foreach($str as $val){
            $a = "($id,$val),";
            $test .=$a;
        }
        $test = trim($test,',');
        $sql = "insert into tag_article (article_id , tag_id) VALUES $test";
        $sta=$this->pdo->prepare($sql);
        $sta->execute();
    }
}