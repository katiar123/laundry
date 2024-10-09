<?php

include __DIR__.'/../model/outlet.php';

class outletController
{
    private $model;

    public function __construct()
    {
        // Membuat instance model outlet
        $this->model = new outletModel;
    }

    // Method untuk menampilkan semua data outlet
    public function index()
    {
        $all = $this->model->index();
        return $all;
    }
    
    public function show($id)
    {
        $show = $this->model->show($id);
        $show = $show -> fetch_assoc();
        return $show;
    }

    public function store($params)
    {
        $insert = $this->model->store($params);

        if ($insert === "success") {
            header("Location:../view/outlet.php");
            exit();
        } else {
            echo $insert;  
        }
    }

    public function destroy($id)
    {
        $destroy = $this->model->destroy($id);
        if ($destroy === "success") {
            header("Location:../view/outlet.php");
            exit();
        } else {
            echo $destroy; 
        }    
    }
    
    public function update($params,$value)
    {
        $update = $this->model->update($params,$value);
        if ($update === "success") {
            header("Location:../view/outlet.php");
            exit();
        } else {
            echo $update;  
        }    
    }

}
