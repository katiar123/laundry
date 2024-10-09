<?php

include __DIR__ . '/../controller/outletController.php';

$outlet = new outletController;

if(isset($_POST['action']))
{
    switch($_POST['action']){
        case 'insert':
            $outlet -> store([$_POST['nama'],$_POST['alamat'],$_POST['telepon']]);
        break;
        case 'update':
            $outlet -> update([$_POST['nama'],$_POST['alamat'],$_POST['telepon']],intval($_POST['id']));
        break;
    }
}
else if(isset($_GET['action']))
{
    switch($_GET['action']){
        case 'destroy':
            $outlet -> destroy($_GET['id']);
        break;
    }
}


