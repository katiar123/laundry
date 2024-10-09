<?php
session_start();
include __DIR__.'/../controller/authController.php';

$user = new authController;
$dataUser = $user -> index();
$data = $user -> getIdOutlet();
if(!isset($_SESSION['admin']) && !isset($_SESSION['kasir']) && !isset($_SESSION['owner']))
{
    header('location:../login.php');
}
if(isset($_GET['id'])){
    $edit = $user->show($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - Laundry Service</title>
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
                <h2 class="text-center mb-4">Tambah User Baru</h2>

                <!-- Form Tambah User -->
                <div class="form-section">
                    <h5>Tambah User</h5>
                    <form action="../routes/auth.php" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= isset($edit['nama']) ? htmlspecialchars($edit['nama']) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= isset($edit['nama']) ? htmlspecialchars($edit['username']) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?= isset($edit['nama']) ? htmlspecialchars($edit['password']) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin" <?= isset($edit['role']) && $edit['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="kasir" <?= isset($edit['role']) && $edit['role'] === 'kasir' ? 'selected' : '' ?>>Kasir</option>
                                <option value="owner <?= isset($edit['role']) && $edit['role'] === 'owner' ? 'selected' : '' ?>">Owner</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="role">Id Outlet</label>
                            <select class="form-control" id="role" name="outlet" required>
                                <option value="">Pilih id outlet</option>
                            <?php
                            foreach($data as $outlet){
                            ?>
                                <option value="<?=$outlet['id']?>" <?= isset($edit['id_outlet'])  ? 'selected' : '' ?>><?=$outlet['id'] . ' - ' . $outlet['nama']?></option>
                            <?php
                            }
                            ?>
                            </select>
                        </div>
                        <input type="hidden" name="id" value="<?= isset($edit['id']) ? htmlspecialchars($edit['id']) : '' ?>">
                        <button type="submit" class="btn btn-primary btn-block" name="action" value="<?= isset($edit)  ? 'update' : 'daftar' ?>"><?= isset($edit)  ? 'Update' : 'Tambah' ?></button>
                    </form>
                </div>
            </div>
            <!-- Tabel Daftar User -->
            <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Id Outlet</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            foreach($dataUser as $user){
                            ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$user['nama']?></td>
                                    <td><?=$user['username']?></td>
                                    <td><?=substr($user['password'],0,20)?></td>
                                    <td><?=$user['role']?></td>
                                    <td><?=$user['id_outlet']?></td>
                                    <td>
                                        <a href="user.php?id=<?=md5($user['id'])?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="../routes/auth.php?id=<?=md5($user['id'])?>&&action=destroy" class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
