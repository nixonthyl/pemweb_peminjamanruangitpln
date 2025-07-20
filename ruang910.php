<?php
session_start(); // Wajib ada di baris paling atas

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ruang 910</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS ini sama persis dengan halaman detail sebelumnya */
        body { background-color: #f9f9f9; }
        .detail-header {
            padding: 40px 5%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('gambar/ruang9.jpg'); /* Gambar diubah */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .detail-header h1 { font-size: 2.5rem; margin: 0; }
        .booking-button { background-color: #28a745; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .detail-container { display: flex; gap: 30px; width: 90%; margin: 40px auto; }
        .image-gallery { flex: 3; }
        .room-details-panel { flex: 2; }
        .main-image img { width: 100%; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .status-box { background-color: #eaf7ec; border-left: 5px solid #28a745; padding: 15px; margin-bottom: 25px; font-weight: 500; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px; }
        .info-box { background: #fff; border: 1px solid #e9e9e9; padding: 15px; text-align: center; border-radius: 5px; }
        .info-box span { display: block; font-size: 0.9rem; color: #777; }
        .info-box strong { font-size: 1.2rem; }
        .facility-section { background: #fff; border: 1px solid #e9e9e9; padding: 25px; border-radius: 8px; }
        .facility-section h3 { margin-top: 0; }
        .facilities-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 20px; }
        .facility-item { text-align: center; }
        .facility-item i { font-size: 2rem; color: #007bff; margin-bottom: 10px; }
        .facility-item span { display: block; font-size: 0.9rem; }
        .site-footer{background-color:#222d3a;color:#cdd6e0;padding:45px 0 20px;font-size:15px;line-height:24px}.footer-container{width:90%;margin:0 auto}.footer-content{display:flex;flex-wrap:wrap;justify-content:space-between;margin-bottom:30px}.footer-column{width:23%;margin-bottom:20px}.footer-column h6{color:#fff;font-size:16px;text-transform:uppercase;margin-top:5px;letter-spacing:2px;margin-bottom:20px}.footer-column a,.footer-column p,.footer-column ul{margin:0;padding:0;list-style:none;color:#cdd6e0;text-decoration:none}.footer-column a:hover{color:#fff}.footer-column .fas{margin-right:10px}.footer-bottom{padding-top:20px;border-top:1px solid #454d58;display:flex;justify-content:space-between;align-items:center}.footer-social-media a{color:#cdd6e0;margin-left:15px;font-size:18px}.footer-social-media a:hover{color:#fff}
    </style>
</head>
<body>

    <header>
         <div class="top-bar"><div class="contact-info"><span><i class="fas fa-phone"></i> +62 823-1360-2560</span><span><i class="fas fa-envelope"></i> info@itpln.ac.id</span></div><div class="social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-youtube"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div><nav class="main-nav"><a href="#" class="logo"><img src="gambar/logo-itpln.png" alt="Logo ITPLN"></a><ul><li><a href="form-peminjaman.php">Home</a></li><li><a href="ruangan.php">Ruangan</a></li><li><a href="statusruangan.php">Status Ruangan <li><a href="peminjaman.php">Peminjaman</a></li><li><a href="logout.php">Logout</a></li></ul></nav>
    </header>

    <div class="detail-header">
        <h1>Ruang 910</h1>
        <a href="peminjaman.php" class="booking-button">Booking</a>
    </div>

    <div class="detail-container">
        <div class="image-gallery">
            <div class="main-image">
                <img id="main-room-image" src="gambar/ruang9.jpg" alt="Ruang 910">
            </div>
            </div>
        <div class="room-details-panel">
            <div class="status-box">
                Ruang 910 tersedia, belum ada yang meminjam.
            </div>
            <div class="info-grid">
                <div class="info-box"><span>Kategori</span><strong>Ruang Kelas</strong></div>
                <div class="info-box"><span>Gedung</span><strong>A ITPLN</strong></div>
                <div class="info-box"><span>Lantai</span><strong>9</strong></div>
                <div class="info-box"><span>Kapasitas</span><strong>40 Orang</strong></div>
            </div>
            <div class="facility-section">
                <h3>Fasilitas Ruang 910</h3>
                <div class="facilities-grid">
                    <div class="facility-item"><i class="fas fa-video"></i><span>Proyektor</span></div>
                    <div class="facility-item"><i class="fas fa-chalkboard-user"></i><span>Papan Tulis</span></div>
                    <div class="facility-item"><i class="fas fa-snowflake"></i><span>AC</span></div>
                    <div class="facility-item"><i class="fas fa-table"></i><span>Meja</span></div>
                    <div class="facility-item"><i class="fas fa-chair"></i><span>Kursi</span></div>
                </div>
            </div>
        </div>
    </div>

    <footer class="site-footer">
        <div class="footer-container"><div class="footer-content"><div class="footer-column"><h6>Sarana & Fasilitas</h6><p><i class="fas fa-phone"></i> +62 2154-4034-2 (Abdul Haris)</p><p><i class="fas fa-envelope"></i> abdulharis@itpln.ac.id</p><p><i class="fas fa-map-marker-alt"></i> Sekretariat Lt. 11 IT-PLN, Duri Kosambi, Cengkareng, Jakarta Barat 11750</p></div><div class="footer-column"><h6>Biro BEM KBM</h6><p><i class="fas fa-envelope"></i> sekretarisbemkbmitpln@gmail.com</p><p><i class="fas fa-phone"></i> +62 895-0659-5952 (Foezy I.A.)</p></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">E-Learning</a></li><li><a href="#">Sistem Akademik</a></li><li><a href="#">Alumni</a></li></ul></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">Info Akademik</a></li><li><a href="#">Jurnal</a></li><li><a href="#">LPPM</a></li></ul></div></div><div class="footer-bottom"><div class="copyright-text"><p>Copyright &copy; 2025 All Rights Reserved by IT-PLN</p></div><div class="footer-social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a></div></div></div>
    </footer>

</body>
</html>