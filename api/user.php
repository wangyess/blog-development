<?php
session_start();

class User extends Model
{
    public $pdo;
    public $table='user';
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function login($rows)
    {
        $username = $rows['username'];
        $password = $rows['password'];
        if (!$username || !$password) {
            return ['success' => false, 'msg' => 'invalid_username || password'];
        }
        //将密码转换\
        $password = $this->password_encrypt($password);
        //判断用户名和密码是否被注册过
        $sql = "select * from user where username=:username and password =:password";
        $sta = $this->pdo->prepare($sql);
        $sta->execute(['username' => $username, 'password' => $password]);
        $r = $sta->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $_SESSION['user'] = $r;
            return ['success' => true, 'data' => $r];
        } else {
            return ['success' => false, 'msg' => 'interval_error'];
        }

    }

    public function logout()
    {
        unset($_SESSION['user']);
        return ['success' => true];
    }

    public function signup($rows)
    {
        $username = @$rows['username'];
        $password = @$rows['password'];
        $permission = $rows['permission'];
        //判断是否传入用户名和密码
        if (!$password || !$username) {
            return ['success' => false, 'msg' => 'invalid_username_password'];
        }
        //在判断用户名是否重复
        $r = $this->username_exists($username);
        if ($r) return ['success' => true, 'msg' => 'exist_username'];
        //密码加密
        $password = $this->password_encrypt($password);
        $sql = "insert into user(username, password, permission) values('{$username}', '{$password}', '{$permission}')";
        $sta = $this->pdo->prepare($sql);
        $r = $sta->execute();
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'interval_error'];
    }

    public function read($rows)
    {
        $data=$this->_read($rows);
        return $data;
    }
    //密码加密
    public function password_encrypt($password)
    {
        return $password = md5(md5($password) . 'ye');
    }

    //判断用户名是否存在
    public function username_exists($username)
    {
        $sql = "select * from user where username = '{$username}'";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetch(PDO::FETCH_ASSOC);
    }
}