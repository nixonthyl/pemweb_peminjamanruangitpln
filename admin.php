<?php
session_start();
include 'koneksi.php';

// --- BAGIAN KEAMANAN (PENTING!) ---
// Memeriksa apakah user sudah login DAN rolenya adalah 'bkmk'
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'bkmk') {
    die("Akses ditolak. Halaman ini hanya untuk admin (BKMK).");
}

// --- LOGIKA UPDATE STATUS SAAT FORM DI-SUBMIT ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    if (!empty($_POST['status'])) {
        $sql_update = "UPDATE peminjaman SET status_bkmk = ? WHERE id_peminjaman = ?";
        $stmt_update = mysqli_prepare($koneksi, $sql_update);
        foreach ($_POST['status'] as $id_peminjaman => $new_status) {
            if ($new_status == 'Disetujui' || $new_status == 'Ditolak') {
                mysqli_stmt_bind_param($stmt_update, 'si', $new_status, $id_peminjaman);
                mysqli_stmt_execute($stmt_update);
            }
        }
        mysqli_stmt_close($stmt_update);
        header('Location: admin.php?update=sukses');
        exit();
    }
}

// --- MENGAMBIL DATA PENGAJUAN YANG MASIH "MENUNGGU" ---
$sql_select = "SELECT p.*, r.nama_ruangan, u.nama_lengkap 
               FROM peminjaman p
               JOIN ruangan r ON p.id_ruangan = r.id_ruangan
               JOIN users u ON p.id_user_pengaju = u.id_user
               WHERE p.status_bkmk = 'Menunggu'
               ORDER BY p.waktu_pengajuan ASC";
$result = mysqli_query($koneksi, $sql_select);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin BKMK - Persetujuan Peminjaman</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS ini diambil dari halaman lain agar tampilan konsisten */
        .page-header { padding: 50px 0; background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('gambar/WhatsApp-Image-2024-04-26-at-08.09.09.jpeg'); background-size: cover; background-position: center; color: white; text-align: center; }
        .page-header h1 { font-size: 2.5rem; margin: 0; }
        .page-header p { font-size: 1.1rem; margin-top: 5px; }
        .content-container { width: 90%; margin: 50px auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; vertical-align: middle; }
        th { background-color: #e9ecef; font-weight: 600; }
        .alert-sukses { color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 12px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .btn-submit { display: block; width: 100%; max-width: 300px; margin: 30px auto 0 auto; background-color: #007bff; color: white; padding: 12px; border: none; border-radius: 5px; font-size: 1.1em; cursor: pointer; font-weight: bold; }
        .btn-submit:hover { background-color: #0056b3; }
        label { margin-right: 15px; cursor: pointer; }
        .site-footer{background-color:#222d3a;color:#cdd6e0;padding:45px 0 20px;font-size:15px;line-height:24px}.footer-container{width:90%;margin:0 auto}.footer-content{display:flex;flex-wrap:wrap;justify-content:space-between;margin-bottom:30px}.footer-column{width:23%;margin-bottom:20px}.footer-column h6{color:#fff;font-size:16px;text-transform:uppercase;margin-top:5px;letter-spacing:2px;margin-bottom:20px}.footer-column a,.footer-column p,.footer-column ul{margin:0;padding:0;list-style:none;color:#cdd6e0;text-decoration:none}.footer-column a:hover{color:#fff}.footer-column .fas{margin-right:10px}.footer-bottom{padding-top:20px;border-top:1px solid #454d58;display:flex;justify-content:space-between;align-items:center}.footer-social-media a{color:#cdd6e0;margin-left:15px;font-size:18px}.footer-social-media a:hover{color:#fff}
    </style>
</head>
<body>

    <header>
        <div class="top-bar"><div class="contact-info"><span><i class="fas fa-phone"></i> +62 823-1360-2560</span><span><i class="fas fa-envelope"></i> info@itpln.ac.id</span></div><div class="social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-youtube"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div>
        <nav class="main-nav">
            <a href="admin.php" class="logo"><img src="gambar/logo-itpln.png" alt="Logo ITPLN"></a>
            <ul>
                <li><a href="admin.php">Dashboard Persetujuan</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="page-header">
        <h1>Panel Admin</h1>
        <p>Persetujuan Peminjaman Ruangan</p>
    </div>

    <div class="content-container">
        <?php if(isset($_GET['update']) && $_GET['update'] == 'sukses'): ?>
            <p class="alert-sukses">✅ Status peminjaman berhasil diperbarui!</p>
        <?php endif; ?>

        <form action="admin.php" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Ruangan</th>
                        <th>Tanggal & Waktu</th>
                        <th>Keperluan</th>
                        <th>Aksi Keputusan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_ruangan']); ?></td>
                                <td><?php echo date('d M Y', strtotime($row['tanggal'])); ?> (<?php echo htmlspecialchars($row['jam_mulai']) . ' - ' . htmlspecialchars($row['jam_selesai']); ?>)</td>
                                <td><?php echo htmlspecialchars($row['keperluan']); ?></td>
                                <td>
                                    <label><input type="radio" name="status[<?php echo $row['id_peminjaman']; ?>]" value="Disetujui"> Setujui</label>
                                    <label><input type="radio" name="status[<?php echo $row['id_peminjaman']; ?>]" value="Ditolak"> Tolak</label>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center;">Tidak ada pengajuan peminjaman baru yang menunggu persetujuan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <button type="submit" name="update_status" class="btn-submit">SUBMIT KEPUTUSAN</button>
            <?php endif; ?>
        </form>
    </div>

    <footer class="site-footer">
        <div class="footer-container"><div class="footer-content"><div class="footer-column"><h6>Sarana & Fasilitas</h6><p><i class="fas fa-phone"></i> +62 2154-4034-2 (Abdul Haris)</p><p><i class="fas fa-envelope"></i> abdulharis@itpln.ac.id</p><p><i class="fas fa-map-marker-alt"></i> Sekretariat Lt. 11 IT-PLN, Duri Kosambi, Cengkareng, Jakarta Barat 11750</p></div><div class="footer-column"><h6>Biro BEM KBM</h6><p><i class="fas fa-envelope"></i> sekretarisbemkbmitpln@gmail.com</p><p><i class="fas fa-phone"></i> +62 895-0659-5952 (Foezy I.A.)</p></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">E-Learning</a></li><li><a href="#">Sistem Akademik</a></li><li><a href="#">Alumni</a></li></ul></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">Info Akademik</a></li><li><a href="#">Jurnal</a></li><li><a href="#">LPPM</a></li></ul></div></div><div class="footer-bottom"><div class="copyright-text"><p>Copyright &copy; 2025 All Rights Reserved by IT-PLN</p></div><div class="footer-social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a></div></div></div>
    </footer>

</body>
</html>
<?php
mysqli_close($koneksi);
?>