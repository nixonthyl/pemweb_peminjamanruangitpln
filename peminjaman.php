<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi Anda sudah benar

// Cek jika pengguna sudah login. Saya asumsikan sessionnya bernama 'id_user'
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// --- LOGIKA PEMROSESAN FORM ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_user_pengaju = $_SESSION['id_user']; // Ambil dari session
    $id_ruangan = $_POST['id_ruangan'];
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $keperluan = htmlspecialchars($_POST['keperluan']);

    // Handle upload file surat permohonan
    $surat_permohonan = '';
    if (isset($_FILES['surat_permohonan']) && $_FILES['surat_permohonan']['error'] == 0) {
        $target_dir = "uploads/surat/";
        $surat_permohonan = $target_dir . time() . '_' . basename($_FILES["surat_permohonan"]["name"]);
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        if (!move_uploaded_file($_FILES["surat_permohonan"]["tmp_name"], $surat_permohonan)) {
            echo "Maaf, terjadi kesalahan saat mengupload file.";
            $surat_permohonan = '';
        }
    }

    // Query untuk insert data ke tabel 'peminjaman'
    $sql = "INSERT INTO peminjaman (id_user_pengaju, id_ruangan, tanggal, jam_mulai, jam_selesai, keperluan, surat_permohonan) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("iisssss", $id_user_pengaju, $id_ruangan, $tanggal, $jam_mulai, $jam_selesai, $keperluan, $surat_permohonan);

    if ($stmt->execute()) {
        // Arahkan ke halaman status ruangan
        header("Location: statusruangan.php?status=sukses");
        exit();
    } else {
        echo "Error saat menyimpan data: " . $stmt->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman Ruangan - IT PLN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container { width: 70%; margin: 50px auto; padding: 40px; background: #fff; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .form-container h1 { text-align: center; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; }
        .time-inputs { display: flex; gap: 20px; }
        .time-inputs .form-group { flex: 1; }
        .btn-submit { width: 100%; padding: 15px; background-color: #007bff; color: white; border: none; border-radius: 5px; font-size: 1.1rem; font-weight: bold; cursor: pointer; transition: background-color 0.2s; }
        .btn-submit:hover { background-color: #0056b3; }
        .page-header{padding:50px 0;background-image:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),url(gambar/WhatsApp-Image-2024-04-26-at-08.09.09.jpeg);background-size:cover;background-position:center;color:#fff;text-align:center}.page-header h1{font-size:2.5rem;margin:0}.page-header p{font-size:1.1rem;margin-top:5px}.site-footer{background-color:#222d3a;color:#cdd6e0;padding:45px 0 20px;font-size:15px;line-height:24px}.footer-container{width:90%;margin:0 auto}.footer-content{display:flex;flex-wrap:wrap;justify-content:space-between;margin-bottom:30px}.footer-column{width:23%;margin-bottom:20px}.footer-column h6{color:#fff;font-size:16px;text-transform:uppercase;margin-top:5px;letter-spacing:2px;margin-bottom:20px}.footer-column a,.footer-column p,.footer-column ul{margin:0;padding:0;list-style:none;color:#cdd6e0;text-decoration:none}.footer-column a:hover{color:#fff}.footer-column .fas{margin-right:10px}.footer-bottom{padding-top:20px;border-top:1px solid #454d58;display:flex;justify-content:space-between;align-items:center}.footer-social-media a{color:#cdd6e0;margin-left:15px;font-size:18px}.footer-social-media a:hover{color:#fff}
    </style>
</head>
<body>

    <header>
        <div class="top-bar"><div class="contact-info"><span><i class="fas fa-phone"></i> +62 823-1360-2560</span><span><i class="fas fa-envelope"></i> info@itpln.ac.id</span></div><div class="social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-youtube"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div><nav class="main-nav"><a href="#" class="logo"><img src="gambar/logo-itpln.png" alt="Logo ITPLN"></a><ul><li><a href="form-peminjaman.php">Home</a></li><li><a href="ruangan.php">Ruangan</a></li><li><a href="statusruangan.php">Status Ruangan <li><a href="peminjaman.php">Peminjaman</a></li><li><a href="logout.php">Logout</a></li></ul></nav>
    </header>

    <div class="page-header">
        <h1>Form Peminjaman Ruangan</h1>
        <p>Silakan isi detail peminjaman Anda di bawah ini.</p>
    </div>

    <div class="form-container">
        <form action="peminjaman.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="id_ruangan">Pilih Ruangan</label>
                <select id="id_ruangan" name="id_ruangan" required>
                    <option value="">-- Pilih Ruangan --</option>
                    <option value="1">Ruang KBM IT-PLN</option>
                    <option value="2">Ruang Satgas</option>
                    <option value="3">Ruang 101 PLN Indonesia Power</option>
                    <option value="4">Ruang 102 PLN Indonesia Power</option>
                    <option value="5">Ruang 103 PLN Indonesia Power</option>
                    <option value="6">Ruang 104 PLN Batam</option>
                    <option value="7">Ruang 105 PLN Batam</option>
                    <option value="8">Ruang 106 PLN Tarakan</option>
                    <option value="9">Ruang 107 PLN Nusantara Power</option>
                    <option value="10">Ruang 108 PLN Nusantara Power</option>
                    <option value="11">Ruang 109 Enjiniring</option>
                    <option value="12">Ruang 110 Pelayaran Bahtera Adhiguna</option>
                    <option value="13">Ruang 111 Gas & Geothermal</option>
                    <option value="14">Ruang 112 PLN Haleyora Power</option>
                    <option value="15">Ruang Mezzanine</option>
                    <option value="16">Ruang Pembangkit</option>
                    <option value="17">Ruang 403B</option>
                    <option value="18">Ruang 404B</option>
                    <option value="19">Ruang 909</option>
                    <option value="20">Ruang 910</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Peminjaman</label>
                <input type="date" id="tanggal" name="tanggal" required>
            </div>

            <div class="time-inputs">
                <div class="form-group">
                    <label for="jam_mulai">Jam Mulai</label>
                    <input type="time" id="jam_mulai" name="jam_mulai" required>
                </div>
                <div class="form-group">
                    <label for="jam_selesai">Jam Selesai</label>
                    <input type="time" id="jam_selesai" name="jam_selesai" required>
                </div>
            </div>

            <div class="form-group">
                <label for="keperluan">Keperluan</label>
                <textarea id="keperluan" name="keperluan" rows="4" placeholder="Contoh: Rapat Koordinasi BEM KBM" required></textarea>
            </div>

            <div class="form-group">
                <label for="surat_permohonan">Upload Surat Permohonan (PDF)</label>
                <input type="file" id="surat_permohonan" name="surat_permohonan" accept=".pdf" required>
            </div>

            <button type="submit" class="btn-submit">Ajukan Peminjaman Ruang</button>
        </form>
    </div>

    <footer class="site-footer">
       <div class="footer-container"><div class="footer-content"><div class="footer-column"><h6>Sarana & Fasilitas</h6><p><i class="fas fa-phone"></i> +62 2154-4034-2 (Abdul Haris)</p><p><i class="fas fa-envelope"></i> abdulharis@itpln.ac.id</p><p><i class="fas fa-map-marker-alt"></i> Sekretariat Lt. 11 IT-PLN, Duri Kosambi, Cengkareng, Jakarta Barat 11750</p></div><div class="footer-column"><h6>Biro BEM KBM</h6><p><i class="fas fa-envelope"></i> sekretarisbemkbmitpln@gmail.com</p><p><i class="fas fa-phone"></i> +62 895-0659-5952 (Foezy I.A.)</p></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">E-Learning</a></li><li><a href="#">Sistem Akademik</a></li><li><a href="#">Alumni</a></li></ul></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">Info Akademik</a></li><li><a href="#">Jurnal</a></li><li><a href="#">LPPM</a></li></ul></div></div><div class="footer-bottom"><div class="copyright-text"><p>Copyright &copy; 2025 All Rights Reserved by IT-PLN</p></div><div class="footer-social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a></div></div></div>
    </footer>

</body>
</html>
<?php
$koneksi->close();
?>