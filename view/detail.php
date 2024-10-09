<?php
    session_start();
    include __DIR__.'/../controller/transaksiController.php';
    $data = new transaksiController;
    $outlet = $data->index('transaksi');

    if(isset($_GET['id'])){
        $transaksi = $data->show('transaksi','id',$_GET['id']);
        $transaksiDetail = $data->show('detail_transaksi','id_transaksi',$_GET['id']);
        $transaksiPaket = $data->show('paket','id',md5($transaksiDetail['id_paket']));
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
    <title>Detail Pesanan - Laundry Service</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
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

        #main-content {
            margin-top: 70px;
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
        <header id="header">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <span class="navbar-brand">Dashboard - Laundry Service</span>
                <div class="ml-auto d-flex align-items-center">
                    <span class="navbar-text mr-3">Selamat datang, <?=isset($_SESSION['admin']['username']) ? $_SESSION['admin']['username'] : $_SESSION['kasir']['username']?></span>
                    <form action="../routes/auth.php" method="post" class="mb-0">
                        <button type="submit" class="btn btn-danger" name="action" value="logout">Logout</button>
                    </form>
                </div>
            </nav>
        </header>

        <!-- Content -->
        <div id="content">
            <div id="main-content" class="container" style="margin-top: 70px">
                <h3>Detail Pesanan</h3>
                <table class="table table-bordered mt-2">
                    <tr>
                        <th>Nama Pelanggan</th>
                        <td><?=$transaksiDetail['nama_pelanggan']?></td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td><?=$transaksiDetail['telepon']?></td>
                    </tr>
                    <tr>
                        <th>Paket</th>
                        <td><?=$transaksiPaket['nama']?></td>
                    </tr>
                    <tr>
                        <th>Deskripsi Paket</th>
                        <td><?=$transaksiPaket['deskripsi']?></td>
                    </tr>
                    <tr>
                        <th>Jumlah (Kg)</th>
                        <td><?=$transaksiDetail['kuantitas'] . ' Kg'?></td>
                    </tr>
                    <tr>
                        <th>Harga per Kg</th>
                        <td><?='Rp '.number_format($transaksiPaket['harga'],0,',','.')?></td>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <td><?='Rp '.number_format($transaksiPaket['harga'] * $transaksiDetail['kuantitas'] + ($transaksiPaket['harga'] * $transaksi['diskon']) + $transaksi['pajak'],0,',','.')?></td>
                    </tr>
                    <tr>
                        <th>Status Pembayaran</th>
                        <td><?=$transaksi['dibayar']?></td>
                    </tr>
                </table>
                <a href="transaksi.php" class="btn btn-primary">Kembali</a>
                <a href="generate-laporan.php?id=<?=md5($transaksi['id'])?>" class="btn btn-info" target="_blank">Generate PDF</a>
            </div>
        </div>
    </div>
</body>

</html>
