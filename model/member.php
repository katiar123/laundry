<?php

include __DIR__.'/../database/database.php';

class memberModel extends Database
{
    private $columns = ['id','nama','jenkel','alamat','telepon'];
    private $table = 'member';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $all = $this->all($this->table);
        return $all;
    }

    public function store($params = [])
    {
        $columns = array_diff($this->columns,['id']);
        $insert = $this->insert($this->table, $columns, $params);
        return $insert;
    }

    public function destroy($id)
    {
        $destroy = $this -> delete($this->table,$this->columns[0],$id);
        return $destroy;
    }
    public function show($id)
    {
        $show = $this -> find($this->table,'id',$id);
        return $show;
    }

    public function update($params, $value)
    {
       
        $columns = array_diff($this->columns,['id']);
        $update = $this->put($this->table, $columns, $this->columns[0], $params, $value);
        return $update;
    }

}
