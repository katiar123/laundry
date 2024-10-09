<?php

include __DIR__ . '/../controller/paketController.php';
session_start();

$paketController = new paketController;

if(isset($_POST['action']))
{
    switch($_POST['action']){
        case 'insert':
            $id_outlet = isset($_SESSION['admin']['id_outlet']) ? $_SESSION['admin']['id_outlet'] : $_SESSION['kasir']['id_outlet'];
            $paketController->store([$id_outlet, $_POST['jenis'], $_POST['nama'], $_POST['deskripsi'], intval($_POST['harga'])]);
        break;
        case 'update':
            $id_outlet = isset($_SESSION['admin']['id_outlet']) ? $_SESSION['admin']['id_outlet'] : $_SESSION['kasir']['id_outlet'];
            $paketController->update([$id_outlet, $_POST['jenis'], $_POST['nama'], $_POST['deskripsi'], intval($_POST['harga'])], $_POST['id']);
        break;
    }
}
else if(isset($_GET['action']))
{
    switch($_GET['action']){
        case 'destroy':
            $paketController->destroy($_GET['id']);
        break;
    }
}
