<?php
session_start();
include __DIR__.'/../controller/transaksiController.php';
$data = new transaksiController;
$transaksi = $data->index('transaksi'); 
$paket = $data->index('paket'); 
$user = $data->index('user'); 
$pendapatan = $data->showPendapatan('transaksi','tanggal_bayar',date('Y-m-d'));
$jumlahTransaksi = count($transaksi); 
$jumlahPaket = count($paket); 
$jumlahUser = count($user); 
$total = 0;
$transaksiToday = 0;
foreach($pendapatan as $subtotal){
    $total += $subtotal['subtotal'];
}
$allTotal = 0;
foreach($transaksi as $subtotal){
    $allTotal += $subtotal['subtotal'];
}

if(!isset($_SESSION['admin']) && !isset($_SESSION['kasir']) && !isset($_SESSION['owner']))
{
    header('location:../login.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Laundry Service</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styling sidebar */
        .wrapper {
            display: flex;
            width: 100%;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #343a40;
            color: #fff;
            height: 100vh;
            position: fixed;
        }

        #sidebar .list-group {
            margin: 0;
        }

        #sidebar .list-group-item {
            background: #343a40;
            color: #fff;
            border: none;
        }

        #sidebar .list-group-item:hover {
            background: #495057;
        }

        #content {
            margin-left: 250px;
            width: 100%;
            padding: 20px;
        }

        /* Styling header */
        #header {
            background-color: #343a40;
            color: white;
            padding: 15px;
            position: fixed;
            top: 0;
            left: 250px;
            width: calc(100% - 250px);
            z-index: 1000;
        }

        #header .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #main-content {
            margin-top: 70px;
        }

        /* Styling cards */
        .dashboard-card {
            transition: transform 0.2s;
        }

        .dashboard-card:hover {
            transform: scale(1.05);
        }

        .dashboard-summary {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header text-center py-4">
                <h4>Laundry Service</h4>
            </div>
            <ul class="list-group">
                <?php
                if(isset($_SESSION['admin'])){
                ?>
                <a href="index.php" class="text-light"><li class="list-group-item">Dashboard</a></li>
                <a href="kasir.php" class="text-light"><li class="list-group-item">Kasir</li></a>
                <a href="transaksi.php" class="text-light"><li class="list-group-item">Transaksi</li></a>
                <a href="paket.php" class="text-light"><li class="list-group-item">Paket</li></a>
                <a href="outlet.php" class="text-light"><li class="list-group-item">Outlet</li></a>
                <a href="user.php" class="text-light"><li class="list-group-item">User</li></a>
                <a href="member.php" class="text-light"><li class="list-group-item">Member</li></a>
                <?php
                    }
                    else if(isset($_SESSION['kasir'])){
                ?>
                <a href="kasir.php" class="text-light"><li class="list-group-item">Kasir</li></a>
                <a href="transaksi.php" class="text-light"><li class="list-group-item">Transaksi</li></a>
                <a href="member.php" class="text-light"><li class="list-group-item">Member</li></a>
                <?php
                    }
                    else{
                ?>
                <a href="transaksi.php" class="text-light"><li class="list-group-item">Transaksi</li></a>

                <?php
                    }
                ?>
            </ul>
        </nav>

        <!-- Header -->
        <!-- Header -->
        <header id="header">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <span class="navbar-brand">Dashboard - Laundry Service</span>
                <div class="ml-auto d-flex align-items-center">
                    <span class="navbar-text mr-3">Selamat datang, <?=$_SESSION['admin']['username']?></span>
                    <form action="../routes/auth.php" method="post" class="mb-0">
                        <button type="submit" class="btn btn-danger" name="action" value="logout">Logout</button>
                    </form>
                </div>
            </nav>
        </header>


        <!-- Content -->
        <div id="content">
            <div id="main-content" class="container" style="margin-top:90px">
                <h2 class="text-center mb-4">Dashboard</h2>
                
                <!-- Cards Dashboard -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card dashboard-card bg-primary text-white mb-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">Jumlah Transaksi(Hari ini)</h5>
                                <p class="card-text"><?=count($pendapatan)?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card dashboard-card bg-success text-white mb-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">Pendapatan (Hari ini)</h5>
                                <p class="card-text"><?='Rp '.number_format($total,0,',','.')?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card dashboard-card bg-warning text-white mb-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">Jumlah Paket Laundry</h5>
                                <p class="card-text"><?=$jumlahPaket?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card dashboard-card bg-danger text-white mb-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">Pengguna Aktif</h5>
                                <p class="card-text"><?=$jumlahUser?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Laporan -->
                <div class="dashboard-summary p-4 mt-4">
                    <h4 class="text-center mb-4">Laporan Singkat</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Total Pendapatan</h5>
                            <p><?='Rp ' . number_format($allTotal,0,',','.')?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Total Transaksi</h5>
                            <p><?=$jumlahTransaksi?> Transaksi</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <a href="transaksi.php" class="btn btn-primary btn-block">Lihat Detail Laporan</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
