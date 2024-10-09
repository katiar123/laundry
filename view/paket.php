<?php
session_start();
include __DIR__.'/../controller/paketController.php';

if(!isset($_SESSION['admin']) && !isset($_SESSION['kasir']) && !isset($_SESSION['owner']))
{
    header('location:../login.php');
}

$data = new paketController;
if(isset($_GET['id'])){
    $edit = $data->showEdit($_GET['id']);
}
$show = $data->show(md5(isset($_SESSION['admin']['id_outlet']) ? $_SESSION['admin']['id_outlet'] : $_SESSION['kasir']['id_outlet']));


?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Laundry - Laundry Service</title>
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
        /* Styling table */
        .table-responsive {
            margin-top: 20px;
        }
        /* Styling form */
        .form-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }
        .form-section h5 {
            margin-bottom: 20px;
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
                    <span class="navbar-text mr-3">Selamat datang, <?=$_SESSION['admin']['username']?></span>
                    <form action="../routes/auth.php" method="post" class="mb-0">
                        <button type="submit" class="btn btn-danger" name="action" value="logout">Logout</button>
                    </form>
                </div>
            </nav>
        </header>

        <!-- Content -->
        <div id="content">
            <div id="main-content" class="container" style="margin-top: 100px">
                <h2 class="text-center mb-4">Kelola Paket Laundry</h2>

                <!-- Form Tambah Paket -->
                <div class="form-section">
                    <h5><?= isset($edit) ? 'Edit Paket Laundry' : 'Tambah Paket Laundry Baru' ?></h5>
                    <form action="../routes/paket.php" method="post">
                        <div class="form-group">
                            <label for="namaPaket">Nama Paket</label>
                            <input type="text" class="form-control" id="namaPaket" name="nama" value="<?= isset($edit['nama']) ? htmlspecialchars($edit['nama']) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsiPaket">Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsiPaket" name="deskripsi" value="<?= isset($edit['deskripsi']) ? htmlspecialchars($edit['deskripsi']) : '' ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="jenisPaket">Jenis Paket</label>
                            <select class="form-control" id="jenisPaket" name="jenis" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Cuci Kering Lipat" <?= isset($edit['jenis']) && $edit['jenis'] === 'Cuci Kering Lipat' ? 'selected' : '' ?>>Cuci Kering Lipat</option>
                                <option value="Cuci Setrika" <?= isset($edit['jenis']) && $edit['jenis'] === 'Cuci Setrika' ? 'selected' : '' ?>>Cuci Setrika</option>
                                <option value="Setrika Saja" <?= isset($edit['jenis']) && $edit['jenis'] === 'Setrika Saja' ? 'selected' : '' ?>>Setrika Saja</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="hargaPaket">Harga (Rp)</label>
                            <input type="number" class="form-control" id="hargaPaket" name="harga" value="<?= isset($edit['harga']) ? htmlspecialchars($edit['harga']) : '' ?>" required>
                        </div>

                        <input type="hidden" name="id" value="<?= isset($edit['id']) ? htmlspecialchars($edit['id']) : '' ?>">
                        <button type="submit" class="btn btn-primary btn-block" name="action" value="<?= isset($edit) ? 'update' : 'insert' ?>">
                            <?= isset($edit) ? 'Update Paket' : 'Tambah Paket' ?>
                        </button>
                    </form>
                </div>

                <!-- Daftar Paket Laundry -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-4">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama Paket</th>
                                <th>Deskripsi</th>
                                <th>Jenis Paket</th>
                                <th>Harga (Rp)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $no = 0;
                            if (!empty($show)) {
                                foreach ($show as $paket) {
                                    $no++;
                        ?>
                            <tr>
                                <td><?=$no?></td>
                                <td><?=$paket['nama']?></td>
                                <td><?=$paket['deskripsi']?></td>
                                <td><?=$paket['jenis']?></td>
                                <td><?='Rp '.number_format($paket['harga'],0,',','.')?></td>
                                <td>
                                    <a href="paket.php?id=<?=md5($paket['id'])?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="../routes/paket.php?action=destroy&&id=<?=md5($paket['id'])?>" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                        <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
