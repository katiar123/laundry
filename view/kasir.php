<?php
session_start();
include __DIR__.'/../controller/paketController.php';

if(!isset($_SESSION['admin']) && !isset($_SESSION['kasir']) && !isset($_SESSION['owner']))
{
    header('location:../login.php');
}

$data = new paketController;
$show = $data->show(md5(isset($_SESSION['admin']['id_outlet']) ? $_SESSION['admin']['id_outlet'] : $_SESSION['kasir']['id_outlet'])); 
$jumlah_paket = count($show); 

if (isset($_SESSION['success'])){
    echo "<script>alert('Pesanan berhasil dibuat')</script>";
    unset($_SESSION['success']);
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Kasir - Laundry Service</title>
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
            <div id="main-content" class="container mt-5">

                <!-- Modal Box untuk Input Pelanggan -->
                <div class="modal fade" id="inputPelangganModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Input Pelanggan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="../routes/transaksi.php" method="post">
                                    <div class="form-group">
                                        <input type="hidden" name="paket" id="paket" class="form-control">
                                        <input type="hidden" name="harga" id="harga" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_pelanggan">Nama Pelanggan</label>
                                        <input type="text" name="nama" id="nama_pelanggan" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="telepon_pelanggan">Telepon</label>
                                        <input type="text" name="telepon" id="telepon_pelanggan" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah (Kg)</label>
                                        <input type="number" name="kuantitas" id="jumlah" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="statusPembayaran">Status Pembayaran</label>
                                        <select class="form-control" id="statusPembayaran" name="statusPembayaran" required>
                                            <option value="Paid">Paid</option>
                                            <option value="Unpaid">Unpaid</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="paket_id_hidden" name="paket_id">
                                    <button type="submit" class="btn btn-primary" name="action" value="insert">Proses Transaksi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Paket Laundry -->
                <div class="container" style="margin-top: 100px">
                    <div class="row">
                        <?php
                        if (!empty($show)) {
                            foreach ($show as $paket) {
                                $nama = isset($paket['nama']) ? htmlspecialchars($paket['nama']) : 'Nama tidak tersedia';
                                $deskripsi = isset($paket['deskripsi']) ? $paket['deskripsi'] : 'Deskripsi tidak tersedia';
                                $harga = isset($paket['harga']) ? 'Rp ' . number_format($paket['harga'], 0, ',', '.') : 'Rp 0';
                        ?>
                                <div class="col-md-4">
                                    <div class="card service-card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $nama ?></h5>
                                            <p class="card-text"><?= $deskripsi ?></p>
                                            <p class="card-text"><strong><?= $harga?></strong></p>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#inputPelangganModal" 
                                            data-id="<?= $paket['id'] ?>"
                                            data-harga="<?= $paket['harga'] ?>"
                                            data-paket="<?= $paket['id'] ?>">Pilih Paket</button>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Tabel Riwayat Transaksi -->
                
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    // Plain JavaScript to handle the modal and data transfer
    document.addEventListener('DOMContentLoaded', function() {
        var inputPelangganModal = document.getElementById('inputPelangganModal');

        // Event listener for buttons with data attributes
        document.querySelectorAll('[data-toggle="modal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                var paketId = button.getAttribute('data-id');
                var harga = button.getAttribute('data-harga');
                var paket = button.getAttribute('data-paket');

                document.getElementById('paket_id_hidden').value = paketId;
                document.getElementById('paket').value = paket;
                document.getElementById('harga').value = harga;
            });
        });

    });
</script>

</body>
</html>
