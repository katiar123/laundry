<?php

include __DIR__.'/../database/database.php';

class paketModel extends Database
{
    private $table = 'paket';
    private $columns = ['id','id_outlet','jenis','nama','deskripsi','harga'];

    public function __construct()
    {
        parent::__construct();
    }

    public function store($params)
    {
        $columns = array_diff($this->columns,['id']);
        $insert = $this->insert($this->table, $columns, $params);
        return $insert;
    }

    public function show($id)
    {
        $show = $this -> find($this->table,$this->columns[1],$id);
        return $show;
    }
    public function showEdit($id)
    {
        $show = $this -> find($this->table,$this->columns[0],$id);
        return $show;
    }
    public function destroy($id)
    {
        $show = $this -> delete($this->table,$this->columns[0],$id);
        return $show;
    }

    public function update($params, $value)
    {
       
        $columns = array_diff($this->columns,['id']);
        $update = $this->put($this->table, $columns, $this->columns[0], $params, $value);
        return $update;
    }
}