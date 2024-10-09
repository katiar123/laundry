<?php
session_start();
include __DIR__.'/../controller/transaksiController.php';
$data = new transaksiController;
$transaksi = $data->index('transaksi');
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
    <title>Transaksi - Laundry Service</title>
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
                    <span class="navbar-text mr-3">Selamat datang,     <?= isset($_SESSION['admin']['username']) ? htmlspecialchars($_SESSION['admin']['username']) : (isset($_SESSION['owner']['username']) ? htmlspecialchars($_SESSION['owner']['username']) : (isset($_SESSION['kasir']['username']) ? htmlspecialchars($_SESSION['kasir']['username']) : 'Pengguna')) ?></span>
                    <form action="../routes/auth.php" method="post" class="mb-0">
                        <button type="submit" class="btn btn-danger" name="action" value="logout">Logout</button>
                    </form>
                </div>
            </nav>
        </header>

        <!-- Content -->
        <div id="content">
            <div id="main-content" class="container" style="margin-top: 100px">
                <h2 class="text-center mb-4">Kelola Transaksi Laundry</h2>           

                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-4">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Tanggal</th>
                                <th>Biaya Tambahan</th>
                                <th>Diskon</th>
                                <th>Pajak</th>
                                <th>Status</th>
                                <th>Dibayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                                foreach($transaksi as $transaksis){
                            ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$transaksis['invoice']?></td>
                                <td><?=explode(' ', $transaksis['tanggal_bayar'])[0]?></td>
                                <td><?='Rp '.number_format($transaksis['biaya_tambahan'],0,',','.')?></td>
                                <td><?=$transaksis['diskon'] * 100 . '%'?></td>
                                <td><?=$transaksis['pajak']?></td>
                                <td><?=$transaksis['status']?></td>
                                <td><?=$transaksis['dibayar']?></td>
                                <td>
                                    <a href="detail.php?id=<?=md5($transaksis['id'])?>" class="btn btn-primary btn-sm">Detail</a>
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="<?=$transaksis['id']?>"  data-status="<?=$transaksis['status']?>">Edit</button>
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
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="../routes/transaksi.php" method="post">
                        <div class="form-group">
                            <label for="statusPembayaran">Status Pembayaran</label>
                            <select class="form-control" id="statusOrder" name="status" required>
                                <option value="baru">Baru</option>
                                <option value="proses">Proses</option>
                                <option value="selesai">Selesai</option>
                                <option value="diambil">Diambil</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="statusPembayaran">Status Pembayaran</label>
                            <select class="form-control" id="statusPembayaran" name="dibayar" required>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>
                        <input type="hidden" id="transaksiId" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="saveChanges" name="action" value="update">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.edit-btn').on('click', function() {
                const berat = $(this).data('berat');
                const status = $(this).data('status');
                const id = $(this).data('id');

                $('#beratLaundry').val(berat);
                $('#statusOrder').val(status);
                $('#transaksiId').val(id);

                $('#editModal').modal('show');
            });

            $('#saveChanges').on('click', function() {
                // Perform AJAX call to update transaction (not implemented here)
                const id = $('#transaksiId').val();
                const berat = $('#beratLaundry').val();
                const status = $('#statusPembayaran').val();

                $('#editModal').modal('hide');
            });
        });
    </script>
</body>
</html>
