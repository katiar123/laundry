<?php

include '../controller/authController.php';

$outlet = new authController;

if(isset($_POST['action']))
{
    switch($_POST['action']){
        case 'login':
            $outlet -> login($_POST['username'],$_POST['password']);
        break;
        case 'daftar':
            $outlet -> register([$_POST['name'],$_POST['username'],password_hash($_POST['password'], PASSWORD_BCRYPT),$_POST['role'],$_POST['outlet']]);
        break;
        case 'update':
            $outlet -> update([$_POST['name'],$_POST['username'],password_hash($_POST['password'], PASSWORD_BCRYPT),$_POST['role'],$_POST['outlet']],$_POST['id']);
        break;
        case 'logout':
            $outlet -> logout();
        break;
    }
}
if(isset($_GET['action']))
{
    switch($_GET['action']){
        case 'logout':
            $outlet -> logout();
        break;
        case 'destroy':
            $outlet -> destroy($_GET['id']);
        break;
    }
}