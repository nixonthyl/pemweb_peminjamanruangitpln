<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

// Menentukan mode halaman: 'cek_status' atau 'riwayat'
$mode = 'riwayat';
if (isset($_GET['ruangan']) && !empty($_GET['ruangan']) && isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
    $mode = 'cek_status';
    $nama_ruangan_cek = $_GET['ruangan'];
    $tanggal_cek = $_GET['tanggal'];
}

if ($mode === 'cek_status') {
    // Mode Cek Status: Menampilkan semua booking untuk ruangan dan tanggal tertentu
    $h1_title = "Jadwal Peminjaman: " . htmlspecialchars($nama_ruangan_cek);
    $p_subtitle = "Pada tanggal " . date('d F Y', strtotime($tanggal_cek));
    
    $sql = "SELECT p.*, r.nama_ruangan 
            FROM peminjaman p 
            JOIN ruangan r ON p.id_ruangan = r.id_ruangan 
            WHERE r.nama_ruangan = ? AND p.tanggal = ? AND p.status_bkmk = 'Disetujui'
            ORDER BY p.jam_mulai ASC";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $nama_ruangan_cek, $tanggal_cek);

} else {
    // Mode Riwayat: Menampilkan riwayat peminjaman user yang login
    $id_user_pengaju = $_SESSION['id_user'];
    $h1_title = "Riwayat Peminjaman Anda";
    $p_subtitle = "Lihat status pengajuan dan riwayat peminjaman ruangan Anda di sini.";

    $sql = "SELECT p.*, r.nama_ruangan
            FROM peminjaman p
            JOIN ruangan r ON p.id_ruangan = r.id_ruangan
            WHERE p.id_user_pengaju = ?
            ORDER BY p.waktu_pengajuan DESC";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_user_pengaju);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Peminjaman - IT PLN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .page-header { padding: 50px 0; background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('gambar/WhatsApp-Image-2024-04-26-at-08.09.09.jpeg'); background-size: cover; background-position: center; color: white; text-align: center; }
        .page-header h1 { font-size: 2.5rem; margin: 0; }
        .page-header p { font-size: 1.1rem; margin-top: 5px; }
        .content-container { width: 80%; margin: 50px auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        .status { padding: 5px 8px; color: white; border-radius: 5px; text-align: center; font-size: 0.9em; text-transform: capitalize; }
        .status-menunggu { background-color: #f0ad4e; }
        .status-disetujui { background-color: #5cb85c; }
        .status-ditolak { background-color: #d9534f; }
        .status-pending { background-color: #777; }
        .alert-sukses { color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px;}
        .site-footer{background-color:#222d3a;color:#cdd6e0;padding:45px 0 20px;font-size:15px;line-height:24px}.footer-container{width:90%;margin:0 auto}.footer-content{display:flex;flex-wrap:wrap;justify-content:space-between;margin-bottom:30px}.footer-column{width:23%;margin-bottom:20px}.footer-column h6{color:#fff;font-size:16px;text-transform:uppercase;margin-top:5px;letter-spacing:2px;margin-bottom:20px}.footer-column a,.footer-column p,.footer-column ul{margin:0;padding:0;list-style:none;color:#cdd6e0;text-decoration:none}.footer-column a:hover{color:#fff}.footer-column .fas{margin-right:10px}.footer-bottom{padding-top:20px;border-top:1px solid #454d58;display:flex;justify-content:space-between;align-items:center}.footer-social-media a{color:#cdd6e0;margin-left:15px;font-size:18px}.footer-social-media a:hover{color:#fff}
    </style>
</head>
<body>

    <header>
        <div class="top-bar"><div class="contact-info"><span><i class="fas fa-phone"></i> +62 823-1360-2560</span><span><i class="fas fa-envelope"></i> info@itpln.ac.id</span></div><div class="social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-youtube"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div><nav class="main-nav"><a href="#" class="logo"><img src="gambar/logo-itpln.png" alt="Logo ITPLN"></a><ul><li><a href="form-peminjaman.php">Home</a></li><li><a href="ruangan.php">Ruangan</a></li><li><a href="statusruangan.php">Status Ruangan</a></li><li><a href="peminjaman.php">Peminjaman</a></li><li><a href="logout.php">Logout</a></li></ul></nav>
    </header>

    <div class="page-header">
        <h1><?php echo $h1_title; ?></h1>
        <p><?php echo $p_subtitle; ?></p>
    </div>

    <div class="content-container">
        <?php if($mode === 'riwayat' && isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
            <p class="alert-sukses">
                ✅ Pengajuan peminjaman berhasil dikirim! Silakan tunggu konfirmasi dari pihak terkait.
            </p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <?php if($mode === 'cek_status'): ?>
                        <th>Waktu Peminjaman</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                    <?php else: ?>
                        <th>Nama Ruangan</th>
                        <th>Tanggal Pinjam</th>
                        <th>Waktu</th>
                        <th>Keperluan</th>
                        <th>Status BKMK</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <?php if($mode === 'cek_status'): ?>
                                <td><?php echo htmlspecialchars($row['jam_mulai']) . ' - ' . htmlspecialchars($row['jam_selesai']); ?></td>
                                <td><?php echo htmlspecialchars($row['keperluan']); ?></td>
                                <td><span class="status status-disetujui">Dipesan</span></td>
                            <?php else: ?>
                                <td><?php echo htmlspecialchars($row['nama_ruangan']); ?></td>
                                <td><?php echo date('d M Y', strtotime($row['tanggal'])); ?></td>
                                <td><?php echo htmlspecialchars($row['jam_mulai']) . ' - ' . htmlspecialchars($row['jam_selesai']); ?></td>
                                <td><?php echo htmlspecialchars($row['keperluan']); ?></td>
                                <td>
                                    <span class="status status-<?php echo strtolower(htmlspecialchars($row['status_bkmk'])); ?>">
                                        <?php echo htmlspecialchars($row['status_bkmk']); ?>
                                    </span>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <?php if($mode === 'cek_status'): ?>
                        <tr><td colspan="4" style="text-align:center; background-color:#d4edda; color: #155724; font-weight: bold;">✅ Ruangan tersedia sepanjang hari pada tanggal ini.</td></tr>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align:center;">Anda belum pernah melakukan peminjaman.</td></tr>
                    <?php endif; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <footer class="site-footer">
        <div class="footer-container"><div class="footer-content"><div class="footer-column"><h6>Sarana & Fasilitas</h6><p><i class="fas fa-phone"></i> +62 2154-4034-2 (Abdul Haris)</p><p><i class="fas fa-envelope"></i> abdulharis@itpln.ac.id</p><p><i class="fas fa-map-marker-alt"></i> Sekretariat Lt. 11 IT-PLN, Duri Kosambi, Cengkareng, Jakarta Barat 11750</p></div><div class="footer-column"><h6>Biro BEM KBM</h6><p><i class="fas fa-envelope"></i> sekretarisbemkbmitpln@gmail.com</p><p><i class="fas fa-phone"></i> +62 895-0659-5952 (Foezy I.A.)</p></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">E-Learning</a></li><li><a href="#">Sistem Akademik</a></li><li><a href="#">Alumni</a></li></ul></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">Info Akademik</a></li><li><a href="#">Jurnal</a></li><li><a href="#">LPPM</a></li></ul></div></div><div class="footer-bottom"><div class="copyright-text"><p>Copyright &copy; 2025 All Rights Reserved by IT-PLN</p></div><div class="footer-social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a></div></div></div>
    </footer>

</body>
</html>
<?php
mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>