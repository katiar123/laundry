<?php

include __DIR__ . '/../controller/transaksiController.php';
session_start();

$outlet = new transaksiController;

if(isset($_POST['action']))
{
    switch($_POST['action']){
        case 'insert':
            $id_outlet = isset($_SESSION['admin']['id_outlet']) ? $_SESSION['admin']['id_outlet'] : $_SESSION['kasir']['id_outlet'];
            $id = isset($_SESSION['admin']['id']) ? $_SESSION['admin']['id'] : $_SESSION['kasir']['id'];
            $outlet -> store([$id_outlet,$_POST['harga'],$_POST['paket'],$_POST['nama'],$_POST['telepon'],
            $_POST['kuantitas'],$id,$_POST['statusPembayaran']]);
        break;
        case 'update':
            $outlet -> update([$_POST['status'],$_POST['dibayar']],$_POST['id']);
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

