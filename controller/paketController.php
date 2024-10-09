<?php 

include __DIR__.'/../model/paket.php';

class paketController
{
    private $model;

    public function __construct()
    {
        $this->model = new paketModel;
    }

    public function store($params)
    {
        $insert = $this->model->store($params);

        if ($insert === "success") {
            header("Location:../view/paket.php");
            exit();
        } else {
            echo $insert;  
        }
    }

    public function show($id)
    {
        $show = $this->model->show($id);
        $show = $show->fetch_all(MYSQLI_ASSOC);
        if (empty($show)) {
            return []; 
        }
        return $show;    
    }

    public function showEdit($id)
    {
        $show = $this->model->showEdit($id);
        $show = $show->fetch_assoc();
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
            header("Location:../view/paket.php");
            exit();
        } else {
            echo $update;  
        }    
    }
}