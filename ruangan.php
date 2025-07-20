<?php
session_start(); // Wajib ada di baris paling atas

// Cek apakah pengguna sudah login, jika tidak, redirect ke halaman login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Data semua ruangan yang dikelompokkan per lantai
$floors = [
    "Lantai 1" => [
        ['nama' => 'Ruang Satgas', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruangsatgas.jpg'],
        ['nama' => 'Ruang KBM IT-PLN', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang kbm.jpg'],
        ['nama' => '101 PLN Indonesia Power', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang ip.jpg'],
        ['nama' => '102 PLN Indonesia Power', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang ip.jpg'],
        ['nama' => '103 PLN Indonesia Power', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang ip.jpg'],
        ['nama' => '104 PLN Batam', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruangbatam.jpg'],
        ['nama' => '105 PLN Batam', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruangbatam.jpg'],
        ['nama' => '106 PLN Tarakan', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang tarakan.jpg'],
        ['nama' => '107 PLN Nusantara Power', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruangnp107.jpg'],
        ['nama' => '108 PLN Nusantara Power', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang np.jpg'],
        ['nama' => '109 Enjiniring', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang109.jpg'],
        ['nama' => '110 Pelayaran Bahtera Adhiguna', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang110.jpg'],
        ['nama' => '111 Gas & Geothermal', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang gas geo.jpg'],
        ['nama' => '112 PLN Haleyora Power', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang112.jpg']
    ],
    "Lantai 2" => [
        ['nama' => 'Ruang Mezzanine', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruangmezzanine.jpg'],
        ['nama' => 'Ruang Pembangkit', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang pembangkit.jpg']
    ],
    "Lantai 4 Gedung B" => [
        ['nama' => 'Ruang 403B', 'lokasi' => 'Gedung B ITPLN', 'gambar' => 'gambar/ruang4b.jpg'],
        ['nama' => 'Ruang 404B', 'lokasi' => 'Gedung B ITPLN', 'gambar' => 'gambar/ruang404.jpg']
    ],
    "Lantai 9" => [
        ['nama' => 'Ruang 909', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang9.jpg'],
        ['nama' => 'Ruang 910', 'lokasi' => 'Gedung A ITPLN', 'gambar' => 'gambar/ruang9.jpg']
    ]
];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Ruangan - IT PLN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS Anda tetap sama */
        .page-header { padding: 50px 0; background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('gambar/WhatsApp-Image-2024-04-26-at-08.09.09.jpeg'); background-size: cover; background-position: center; color: white; text-align: center; }
        .page-header h1 { font-size: 2.5rem; margin: 0; }
        .page-header p { font-size: 1.1rem; margin-top: 5px; }
        .room-listing-container { width: 90%; margin: 40px auto; }
        .floor-section { margin-bottom: 50px; }
        .floor-title { font-size: 2rem; font-weight: bold; border-bottom: 3px solid #f0ad4e; padding-bottom: 10px; margin-bottom: 30px; }
        .room-cards-container { display: flex; flex-wrap: wrap; gap: 25px; }
        .room-card { flex-basis: calc(33.333% - 25px); background: #fff; border: 1px solid #eee; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .room-card:hover { transform: translateY(-5px); }
        .room-card img { width: 100%; height: 200px; object-fit: cover; }
        .card-body { padding: 20px; text-align: center; }
        .card-body h5 { font-size: 1.1rem; margin: 0 0 10px 0; font-weight: bold; }
        .card-body p { font-size: 0.9rem; color: #666; margin-bottom: 20px; }
        .btn-details { display: inline-block; background-color: #28a745; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; }
        .btn-details:hover { background-color: #218838; }
        .site-footer{background-color:#222d3a;color:#cdd6e0;padding:45px 0 20px;font-size:15px;line-height:24px}.footer-container{width:90%;margin:0 auto}.footer-content{display:flex;flex-wrap:wrap;justify-content:space-between;margin-bottom:30px}.footer-column{width:23%;margin-bottom:20px}.footer-column h6{color:#fff;font-size:16px;text-transform:uppercase;margin-top:5px;letter-spacing:2px;margin-bottom:20px}.footer-column a,.footer-column p,.footer-column ul{margin:0;padding:0;list-style:none;color:#cdd6e0;text-decoration:none}.footer-column a:hover{color:#fff}.footer-column .fas{margin-right:10px}.footer-bottom{padding-top:20px;border-top:1px solid #454d58;display:flex;justify-content:space-between;align-items:center}.footer-social-media a{color:#cdd6e0;margin-left:15px;font-size:18px}.footer-social-media a:hover{color:#fff}
    </style>
</head>
<body>

    <header>
         <div class="top-bar"><div class="contact-info"><span><i class="fas fa-phone"></i> +62 823-1360-2560</span><span><i class="fas fa-envelope"></i> info@itpln.ac.id</span></div><div class="social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-youtube"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div><nav class="main-nav"><a href="#" class="logo"><img src="gambar/logo-itpln.png" alt="Logo ITPLN"></a><ul><li><a href="form-peminjaman.php">Home</a></li><li><a href="ruangan.php">Ruangan</a></li><li><a href="statusruangan.php">Status Ruangan <li><a href="peminjaman.php">Peminjaman</a></li><li><a href="logout.php">Logout</a></li></ul></nav>
    </header>

    <div class="page-header">
        <h1>RUANGAN INSTITUT TEKNOLOGI PLN</h1>
        <p>Ruangan yang dapat di pinjam di ITPLN</p>
    </div>

    <div class="room-listing-container">
        <?php foreach ($floors as $floor_name => $rooms): ?>
            <div class="floor-section">
                <h2 class="floor-title"><?php echo $floor_name; ?></h2>
                <div class="room-cards-container">
                    <?php foreach ($rooms as $room): ?>
                        <div class="room-card">
                            <img src="<?php echo htmlspecialchars($room['gambar']); ?>" alt="<?php echo htmlspecialchars($room['nama']); ?>">
                            <div class="card-body">
                                <h5><?php echo htmlspecialchars($room['nama']); ?></h5>
                                <p><?php echo htmlspecialchars($room['lokasi']); ?></p>
                                
                                <?php
                                // ### LOGIKA LINK DIPERBARUI DI SINI ###
                                $detail_link = "#"; // Link default
                                
                                if ($room['nama'] == 'Ruang KBM IT-PLN') {
                                    $detail_link = "ruangkbm.php";
                                } elseif ($room['nama'] == 'Ruang Satgas') {
                                    $detail_link = "ruangsatgas.php";
                                } elseif ($room['nama'] == '101 PLN Indonesia Power') {
                                    $detail_link = "ruang101.php";
                                } elseif ($room['nama'] == '102 PLN Indonesia Power') {
                                    $detail_link = "ruang102.php";
                                } elseif ($room['nama'] == '103 PLN Indonesia Power') {
                                    $detail_link = "ruang103.php";
                                } elseif ($room['nama'] == '104 PLN Batam') {
                                    $detail_link = "ruang104.php";
                                } elseif ($room['nama'] == '105 PLN Batam') {
                                    $detail_link = "ruang105.php";
                                } elseif ($room['nama'] == '106 PLN Tarakan') {
                                    $detail_link = "ruang106.php";
                                } elseif ($room['nama'] == '107 PLN Nusantara Power') {
                                    $detail_link = "ruang107.php";
                                } elseif ($room['nama'] == '108 PLN Nusantara Power') {
                                    $detail_link = "ruang108.php";
                                } elseif ($room['nama'] == '109 Enjiniring') {
                                    $detail_link = "ruang109.php";
                                } elseif ($room['nama'] == '110 Pelayaran Bahtera Adhiguna') {
                                    $detail_link = "ruang110.php";
                                } elseif ($room['nama'] == '111 Gas & Geothermal') {
                                    $detail_link = "ruang111.php";
                                } elseif ($room['nama'] == '112 PLN Haleyora Power') {
                                    $detail_link = "ruang112.php";
                                } elseif ($room['nama'] == 'Ruang Mezzanine') {
                                    $detail_link = "ruangmezzanine.php";
                                } elseif ($room['nama'] == 'Ruang Pembangkit') {
                                    $detail_link = "ruangpembangkit.php";
                                } elseif ($room['nama'] == 'Ruang 403B') {
                                    $detail_link = "ruang403b.php";
                                } elseif ($room['nama'] == 'Ruang 404B') {
                                    $detail_link = "ruang404b.php";
                                } elseif ($room['nama'] == 'Ruang 909') {
                                    $detail_link = "ruang909.php";
                                } elseif ($room['nama'] == 'Ruang 910') {
                                    $detail_link = "ruang910.php";
                                } 
                                ?>
                                <a href="<?php echo $detail_link; ?>" class="btn-details">View Details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer class="site-footer">
        <div class="footer-container"><div class="footer-content"><div class="footer-column"><h6>Sarana & Fasilitas</h6><p><i class="fas fa-phone"></i> +62 2154-4034-2 (Abdul Haris)</p><p><i class="fas fa-envelope"></i> abdulharis@itpln.ac.id</p><p><i class="fas fa-map-marker-alt"></i> Sekretariat Lt. 11 IT-PLN, Duri Kosambi, Cengkareng, Jakarta Barat 11750</p></div><div class="footer-column"><h6>Biro BEM KBM</h6><p><i class="fas fa-envelope"></i> sekretarisbemkbmitpln@gmail.com</p><p><i class="fas fa-phone"></i> +62 895-0659-5952 (Foezy I.A.)</p></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">E-Learning</a></li><li><a href="#">Sistem Akademik</a></li><li><a href="#">Alumni</a></li></ul></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">Info Akademik</a></li><li><a href="#">Jurnal</a></li><li><a href="#">LPPM</a></li></ul></div></div><div class="footer-bottom"><div class="copyright-text"><p>Copyright &copy; 2025 All Rights Reserved by IT-PLN</p></div><div class="footer-social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a></div></div></div>
    </footer>

</body>
</html>