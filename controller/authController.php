<?php 

include __DIR__.'/../model/user.php';

class authController
{
    private $model;

    public function __construct()
    {
        $this->model = new authModel;
    }

    public function index()
    {
        $all = $this->model->index();
        return $all;
    }
    
    public function getIdOutlet()
    {
        $all = $this->model->idOutlet();
        return $all;
    }

    public function login($username, $password)
    {
        $user = $this->model->login($username);
        $user = $user -> fetch_assoc();
        session_start();
    
        if (is_array($user)) 
        {
            if (password_verify($password, $user['password'])) 
            {
                if ($user['role'] == "kasir") 
                {
                    $_SESSION['kasir'] = $user;
                    header("Location:../view/kasir.php");
                } 
                else if ($user['role'] == "admin") 
                {
                    $_SESSION['admin'] = $user;
                    header("Location: ../view/index.php");
                }
                else if ($user['role'] == "owner") 
                {
                    $_SESSION['admin'] = $user;
                    header("Location: ../view/transaksi.php");
                }
                exit();
            } 
            else 
            {
                header("Location: ../view/login.php");
                $_SESSION['error'] = "Username atau password salah!";
                exit();
            }
        } 
        else 
        {
            $_SESSION['error'] = "Username atau password salah!";
        }
    }
    

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("location:../view/login.php");
    }

    public function register($params)
    {
        $register = $this->model->store($params);
        if ($register === "success") {
            header("Location:../view/user.php");
            exit();
        } else {
            echo $register; 
        }
    }
    public function update($params,$value)
    {
        $update = $this->model->update($params,$value);
        if ($update === "success") {
            header("Location:../view/user.php");
            exit();
        } else {
            echo $update;  
        }    
    }

    public function show($id)
    {
        $show = $this->model->show($id);
        $show = $show -> fetch_assoc();
        return $show;
    }

    public function destroy($id)
    {
        $destroy = $this->model->destroy($id);
        if ($destroy === "success") {
            header("Location:../view/user.php");
            exit();
        } else {
            echo $destroy; 
        }    
    }
}
