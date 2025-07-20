<?php
session_start(); // Wajib ada di baris paling atas

// Cek apakah pengguna sudah login, jika tidak, redirect ke halaman login
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
    <title>Sistem Peminjaman Ruang - IT PLN</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .hero-section { 
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('gambar/WhatsApp-Image-2024-04-26-at-08.09.09.jpeg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            position: relative; 
            /* ### DIUBAH DI SINI: DARI 70vh MENJADI 100vh ### */
            height: 90vh; 
            color: white;
        }

        .hero-content {
            position: absolute;
            top: 120px; 
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            text-align: center;
        }

        .booking-form-container {
            position: absolute;
            bottom: 40px; 
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 900px;
        }
        
        input[type="date"] { position: relative; }
        input[type="date"]::-webkit-calendar-picker-indicator { position: absolute; top: 0; right: 0; width: 100%; height: 100%; padding: 0; margin: 0; background: transparent; color: transparent; cursor: pointer; }
        .site-footer { background-color: #222d3a; color: #cdd6e0; padding: 45px 0 20px; font-size: 15px; line-height: 24px; }
        .footer-container{width:90%;margin:0 auto}.footer-content{display:flex;flex-wrap:wrap;justify-content:space-between;margin-bottom:30px}.footer-column{width:23%;margin-bottom:20px}.footer-column h6{color:#fff;font-size:16px;text-transform:uppercase;margin-top:5px;letter-spacing:2px;margin-bottom:20px}.footer-column a,.footer-column p,.footer-column ul{margin:0;padding:0;list-style:none;color:#cdd6e0;text-decoration:none}.footer-column a:hover{color:#fff}.footer-column .fas{margin-right:10px}.footer-bottom{padding-top:20px;border-top:1px solid #454d58;display:flex;justify-content:space-between;align-items:center}.footer-social-media a{color:#cdd6e0;margin-left:15px;font-size:18px}.footer-social-media a:hover{color:#fff}
    </style>
</head>
<body>

    <header>
        <div class="top-bar"><div class="contact-info"><span><i class="fas fa-phone"></i> +62 823-1360-2560</span><span><i class="fas fa-envelope"></i> info@itpln.ac.id</span></div><div class="social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-youtube"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div><nav class="main-nav"><a href="#" class="logo"><img src="gambar/logo-itpln.png" alt="Logo ITPLN"></a><ul><li><a href="form-peminjaman.php">Home</a></li><li><a href="ruangan.php">Ruangan</a></li><li><a href="statusruangan.php">Status Ruangan</a></li><li><a href="peminjaman.php">Peminjaman</a></li><li><a href="logout.php">Logout</a></li></ul></nav>
    </header>

    <main class="hero-section">
        <div class="hero-content">
            <p>Welcome To SiPinjam</p>
            <h1>SISTEM PEMINJAMAN RUANG</h1>
            <h2>INSTITUT TEKNOLOGI PLN</h2>
        </div>
        <div class="booking-form-container">
            <form class="booking-form" action="statusruangan.php" method="GET">
                <div class="form-group">
                    <label for="tanggal-cek">Pilih Tanggal</label>
                    <input type="date" id="tanggal-cek" name="tanggal" required>
                </div>
                <div class="form-group">
                    <label for="lantai">Lantai</label>
                    <select id="lantai">
                        <option value="">-- Pilih Lantai --</option>
                        <option value="Lantai 1">Lantai 1</option>
                        <option value="Lantai 2">Lantai 2</option>
                        <option value="Lantai 4 Gedung B">Lantai 4 Gedung B</option>
                        <option value="Lantai 9">Lantai 9</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ruangan">Ruangan</label>
                    <select id="ruangan" name="ruangan" disabled required>
                        <option value="">-- Pilih Lantai Dahulu --</option>
                    </select>
                </div>
                <button type="submit" class="btn-check">Check</button>
            </form>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-container"><div class="footer-content"><div class="footer-column"><h6>Sarana & Fasilitas</h6><p><i class="fas fa-phone"></i> +62 2154-4034-2 (Abdul Haris)</p><p><i class="fas fa-envelope"></i> abdulharis@itpln.ac.id</p><p><i class="fas fa-map-marker-alt"></i> Sekretariat Lt. 11 IT-PLN, Duri Kosambi, Cengkareng, Jakarta Barat 11750</p></div><div class="footer-column"><h6>Biro BEM KBM</h6><p><i class="fas fa-envelope"></i> sekretarisbemkbmitpln@gmail.com</p><p><i class="fas fa-phone"></i> +62 895-0659-5952 (Foezy I.A.)</p></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">E-Learning</a></li><li><a href="#">Sistem Akademik</a></li><li><a href="#">Alumni</a></li></ul></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">Info Akademik</a></li><li><a href="#">Jurnal</a></li><li><a href="#">LPPM</a></li></ul></div></div><div class="footer-bottom"><div class="copyright-text"><p>Copyright &copy; 2025 All Rights Reserved by IT-PLN</p></div><div class="footer-social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a></div></div></div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dataRuangan = {
                "Lantai 1": ["Ruang Satgas", "Ruang KBM IT-PLN", "Ruang 101 PLN Indonesia Power", "Ruang 102 PLN Indonesia Power", "Ruang 103 PLN Indonesia Power", "Ruang 104 PLN Batam", "Ruang 105 PLN Batam", "Ruang 106 PLN Tarakan", "Ruang 107 PLN Nusantara Power", "Ruang 108 PLN Nusantara Power", "Ruang 109 Enjiniring", "Ruang 110 Pelayaran Bahtera Adhiguna", "Ruang 111 Gas & Geothermal", "Ruang 112 PLN Haleyora Power"],
                "Lantai 2": ["Ruang Mezzanine", "Ruang Pembangkit"],
                "Lantai 4 Gedung B": ["Ruang 403B", "Ruang 404B"],
                "Lantai 9": ["Ruang 909", "Ruang 910"]
            };

            const lantaiSelect = document.getElementById('lantai');
            const ruanganSelect = document.getElementById('ruangan');

            function updateRuangan() {
                const selectedLantai = lantaiSelect.value;
                ruanganSelect.innerHTML = '';

                if (selectedLantai && dataRuangan[selectedLantai]) {
                    ruanganSelect.disabled = false;
                    ruanganSelect.add(new Option('-- Pilih Ruangan --', ''));
                    dataRuangan[selectedLantai].forEach(function(namaRuangan) {
                        let option = new Option(namaRuangan, namaRuangan);
                        ruanganSelect.add(option);
                    });
                } else {
                    ruanganSelect.disabled = true;
                    ruanganSelect.add(new Option('-- Pilih Lantai Dahulu --', ''));
                }
            }
            lantaiSelect.addEventListener('change', updateRuangan);
        });
    </script>
</body>
</html>