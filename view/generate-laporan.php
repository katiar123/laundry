<?php
require('../fpdf/fpdf/fpdf.php');
include __DIR__.'/../controller/transaksiController.php';

if(isset($_GET['id'])){
    $data = new transaksiController;
    $transaksi = $data->show('transaksi', 'id', $_GET['id']);
    $transaksiDetail = $data->show('detail_transaksi', 'id_transaksi', $_GET['id']);
    $transaksiPaket = $data->show('paket', 'id', md5($transaksiDetail['id_paket']));

    // Membuat instance FPDF dengan ukuran struk 58mm x 100mm
    $pdf = new FPDF('P', 'mm', array(58, 100));
    $pdf->AddPage();
    
    // Judul
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, 'Laundry Service', 0, 1, 'C');
    $pdf->Ln(2);
    
    // Info Pesanan
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 4, '=========================', 0, 1, 'C');
    $pdf->Cell(0, 4, 'Detail Pesanan', 0, 1, 'C');
    $pdf->Cell(0, 4, '=========================', 0, 1, 'C');
    
    $pdf->Cell(20, 4, 'Nama:', 0, 0);
    $pdf->Cell(0, 4, $transaksiDetail['nama_pelanggan'], 0, 1);
    
    $pdf->Cell(20, 4, 'Telepon:', 0, 0);
    $pdf->Cell(0, 4, $transaksiDetail['telepon'], 0, 1);
    
    $pdf->Cell(20, 4, 'Paket:', 0, 0);
    $pdf->Cell(0, 4, $transaksiPaket['nama'], 0, 1);
    
    $pdf->Cell(20, 4, 'Jumlah:', 0, 0);
    $pdf->Cell(0, 4, $transaksiDetail['kuantitas'] . ' Kg', 0, 1);
    
    $pdf->Cell(20, 4, 'Harga/Kg:', 0, 0);
    $pdf->Cell(0, 4, 'Rp '.number_format($transaksiPaket['harga'],0,',','.'), 0, 1);
    
    $totalHarga = $transaksiPaket['harga'] * $transaksiDetail['kuantitas'] + ($transaksiPaket['harga'] * $transaksi['diskon']) + $transaksi['pajak'];
    $pdf->Cell(20, 4, 'Total Harga:', 0, 0);
    $pdf->Cell(0, 4, 'Rp '.number_format($totalHarga,0,',','.'), 0, 1);
    
    $pdf->Cell(20, 4, 'Dibayar:', 0, 0);
    $pdf->Cell(0, 4, $transaksi['dibayar'], 0, 1);

    // Footer
    $pdf->Ln(5);
    $pdf->Cell(0, 4, 'Terima Kasih', 0, 1, 'C');
    $pdf->Cell(0, 4, 'Laundry Service', 0, 1, 'C');

    $pdf->Output();
}
?>
