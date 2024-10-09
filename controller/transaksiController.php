<?php 

include __DIR__.'/../model/transaksi.php';

class transaksiController
{
    private $model;

    public function __construct()
    {
        $this->model = new transaksiModel;
    }

    public function index($table)
    {
        $all = $this->model->index($table);
        return $all;
    }
    
    public function store($params)
    {
        $pajak = $params[1] * 0.1;
        $pengemasan = $params[1] * $params[5] * 0.01;
        $diskon = 0;

        if ($params[5] >= 5) {
            $diskon = 0.20;
        }

        $subtotal = $params[1] * $params[5] + ($params[1] * $diskon);

        $invoice = 'INV' . date('ymd') . rand(100, 10000);

        $paramTransaksi = [
            $params[0],           
            $invoice,              
            $pengemasan,
            $diskon,         
            $pajak,
            $params[7],  
            $subtotal,
            $params[6],          
        ];

        $insert = $this->model->store($paramTransaksi);

        if ($insert === "success") {
            $id_transaksi = $this->model->getLastInsertId();

            $detailParams = [
                $id_transaksi,
                $params[2], 
                $params[3],
                $params[4],
                $params[5],
            ];

            $detailInsert = $this->model->insertDetail($detailParams);

            if ($detailInsert !== "success") {
                echo $detailInsert;  
            }

            session_start();
            $_SESSION['success'] = 'Pesanan berhasil dibuat'; 
            
            header("Location: ../view/kasir.php");
            exit();
        } else {
            echo $insert;  
        }
    }


    public function show($table,$column,$id)
    {
        $show = $this->model->show($table,$column,$id);
        $show = $show->fetch_assoc();
        if (empty($show)) {
            return []; 
        }
        return $show;    
    }
    public function showPendapatan($table,$column,$id)
    {
        $show = $this->model->show($table,$column,$id);
        $show = $show->fetch_all(MYSQLI_ASSOC);
        if (empty($show)) {
            return []; 
        }
        return $show;    
    }

    public function destroy($id)
    {
        $destroy = $this->model->destroy($id);
        if ($destroy === "success") {
            header("Location:../view/paket.php");
            exit();
        } else {
            echo $destroy;  
        }    
    }

    public function update($params,$value)
    {
        $update = $this->model->update($params,$value);
        if ($update === "success") {
            header("Location:../view/transaksi.php");
            exit();
        } else {
            echo $update;  
        }    
    }
}