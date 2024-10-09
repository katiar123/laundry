<?php

include __DIR__.'/../database/database.php';

class authModel extends Database
{
    private $columns = ['id','nama', 'username', 'password', 'role','id_outlet'];
    private $table = 'user';

    public function __construct()
    {
        parent::__construct();
        $this->columns = array_diff($this->columns,['id']);    
    }

    public function index()
    {
        $all = $this->all($this->table);
        return $all;
    }
    
    public function idOutlet()
    {
        $all = $this->all('outlet');
        return $all;
    }

    public function login($username)
    {
        $login = $this->find($this->table,$this->columns[1],$username);
        return $login;
    }

    public function store($params)
    {
        $register = $this->insert($this->table,$this->columns,$params);
        return $register;
    }

    public function show($id)
    {
        $show = $this -> find($this->table,'id',$id);
        return $show;
    }

    public function update($params, $value)
    {
        $columns = array_diff($this->columns,['id']);
        $update = $this->put($this->table, $columns,'id', $params, $value);
        return $update;
    }

    public function destroy($id)
    {
        $destroy = $this -> delete($this->table,'id',$id);
        return $destroy;
    }
}
