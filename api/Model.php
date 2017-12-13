<?php
session_start();

class Model
{
    function _read($opt = [])
    {
        $id = $opt['id'];
        $page = $opt['page'] ?: 1;
        $limit = $opt['limit'] ?: 10;
        $by = $opt['by'] ?: 'id';
        $de = $opt['de'] ?: 'desc';
        $title = $opt['title'];
        if ($id) {
            $aa = $this->find_this_item($id);
            if (!$aa) {
                return ['success' => false, 'msg' => 'invalid_id'];
            }
            $sql = "select * from $this->table where id = $id";
        } else {
            if ($title) {
                $sql = "select * from $this->table where title = '{$title}'";
            } else {
                if ($limit) {
                    $offset = $limit * ($page - 1);
                    $sql_limit = " limit $offset, $limit";
                }
                if ($by) {
                    $sql_order = " order by $by $de";
                }
                $sql = "select * from $this->table $sql_order $sql_limit";
            }
        }
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        $r = $sta->fetchAll(PDO::FETCH_ASSOC);
        return $r ? ['success' => true, 'data' => $r] : ['success' => false, 'msg' => 'internal_error'];
    }

    function _remove($opt = [])
    {
        $id = $opt['id'];
        if (!$id) {
            return ['success' => false, 'msg' => 'internal_id'];
        }
        $sql = "delete from $this->table where id = $id";
        $sta = $this->pdo->prepare($sql);
        $r = $sta->execute();
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    function _add($opt = [])
    {
        return $this->add_or_update('add', $opt);
    }

    function _update($opt = [])
    {
        return $this->add_or_update('update', $opt);
    }

    function add_or_update($type, $opt)
    {
        $is_add = $type == 'add';
        if ($is_add) {
            //不许自己设置id
            unset($opt['id']);
        } else {
            //判断数据中是否存在这条数据
            $id = $opt['id'];
            if (!$id) {
                return ['success' => false, 'msg' => 'internal_id'];
            }
            $old = $this->find_this_item($id);
            if (!$old) {
                return ['success' => false, 'msg' => 'internal_id'];
            }
            $opt = array_merge($old, $opt);
        }
        if ($type == 'add') {
            //生成sql 语句
            $sql = $this->create_add_sql($opt);
        } else {
            //生成sql语句
            $sql = $this->create_update_sql($opt);
        }
        $sta = $this->pdo->prepare($sql);
        $r = $sta->execute();
        return $r ? ['success' => true,'data'=>$this->pdo->lastInsertId()] : ['success' => false, 'msg' => 'internal_error'];
    }

    //生成增加语句
    function create_add_sql($opt)
    {
        $sql_key = '';
        $sql_val = '';
        $aa = $this->column_name_list();
        foreach ($opt as $key => $val) {
            if (in_array($key, $aa)) {
                $sql_key .= $key . ',';
                $sql_val .= "'" . $val . "'" . ',';
            } else {
                continue;
            }
        }
        $sql_key = trim($sql_key, ',');
        $sql_val = trim($sql_val, ',');
        return $sql = "insert into $this->table ( $sql_key ) VALUES ( $sql_val ) ";
    }

    //生成更新语句
    function create_update_sql($opt)
    {
        $id = $opt['id'];
        $col = '';
        $aa = $this->column_name_list();
        foreach ($opt as $key => $val) {
            if (in_array($key, $aa)) {
                //更新的时候id 不能让更新
                if ($key == 'id') continue;
                if ($opt[ $key ] == '') continue;
                $col .= $key . " = '" . $val . "',";
            } else {
                continue;
            }
        }
        $col = trim($col, ',');
        return $sql = "update $this->table set $col where id = $id";
    }

    //取到你要编辑这个表单中所有 键
    function column_list()
    {
        $sql = "desc $this->table";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }

    function column_name_list()
    {
        $name_list = [];
        $list = $this->column_list();
        foreach ($list as $key) {
            $name_list[] = $key['Field'];
        }
        return $name_list;
    }

    //查找一条是不是在数据库中
    function find_this_item($id)
    {
        $sql = "select * from $this->table where id = $id";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    //获取表中的数据个数
    function read_count()
    {
        $sql = "select count(*) from $this->table";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $r = $sta->fetchAll(PDO::FETCH_NUM)[0];
    }
}