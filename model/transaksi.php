<?php

include __DIR__.'/../database/database.php';

class transaksiModel extends Database
{
    private $table = 'transaksi';
    private $columns = ['id','id_outlet','invoice','biaya_tambahan','diskon','pajak','status','dibayar','subtotal','id_user'];

    public function __construct()
    {
        parent::__construct();
    }

    public function index($table)
    {
        $all = $this->all($table);
        return $all;
    }

    public function store($params)
    {
        $columns = array_diff($this->columns, ['id', 'status']);
        $insert = $this->insert($this->table, $columns, $params);
        return $insert;
    }


    public function show($table,$column,$id)
    {
        $show = $this -> find($table,$column,$id);
        return $show;
    }

    public function showDetail($id)
    {
        $show = $this -> find('detail_transaksi','id_transaksi',$id);
        return $show;
    }
    public function destroy($id)
    {
        $show = $this -> delete($this->table,$this->columns[0],$id);
        return $show;
    }

    public function insertDetail($params)
    {
        $columns = ['id_transaksi', 'id_paket', 'nama_pelanggan', 'telepon', 'kuantitas'];
        return $this->insert('detail_transaksi', $columns, $params);
    }

    public function update($params, $value)
    {
       
        $update = $this->put($this->table, ['status','dibayar'], $this->columns[0], $params, $value);
        return $update;
    }

}