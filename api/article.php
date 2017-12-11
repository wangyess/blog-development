<?php
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
        return $data ? ['success' => true, 'data' => $data] : ['success' => false, 'msg' => 's'];
    }

    public function add($rows)
    {
        $data=$this->_add($rows);
        return $data?['success' => true]:['success' => false, 'msg' => 'internal_error'];
    }

    public function remove($rows)
    {
        $id = $rows['id'];
        //在数据找一下 看看是否存在
        $data = $this->find($id);
        if (!$data) {
            return ['success' => false, 'msg' => 'invalid_id'];
        }
        $sql = "delete from article where id = $id";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return ['success' => true];
    }

    public function update($rows)
    {
        $id = $rows['id'];
        $title = $rows['title'];
        $content = $rows['content'];
        $create_time = $rows['create_time'];
        $update_time = $rows['update_time'];
        $author_id = $rows['author_id'];
        if (!$id) {
            return ['success' => false, 'msg' => 'invalid_id'];
        }
        //判断在数据库是否可以找到这条数据
        $old = $this->find_item($id);
        if (!$old) {
            return ['success' => false, 'msg' => 'internal_id'];
        }
        $new_item = array_merge($old, $rows);
        $sql = "update article set title =:title , content=:content , create_time=:create_time, update_time =:update_time,author_id=:author_id  where id =:id ";
        $sta = $this->pdo->prepare($sql);
        $sta->execute($new_item);
        return true;
    }

    public function find($id)
    {
        $sql = "select * from article where id = $id ";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    public function find_item($id)
    {
        $sql = "select * from article where id = $id";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetch(PDO::FETCH_ASSOC);
    }
}