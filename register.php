<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = htmlspecialchars($_POST['role']);
    $nama_ormawa = htmlspecialchars($_POST['nama_ormawa']);
    $sql = "INSERT INTO users (nama_lengkap, email, password, role, nama_ormawa) VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sssss", $nama_lengkap, $email, $password, $role, $nama_ormawa);
    if ($stmt->execute()) {
        header("Location: login.php?register=sukses");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sistem Peminjaman Ruang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body { margin: 0; font-family: sans-serif; }
        .main-container {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('gambar/WhatsApp-Image-2024-04-26-at-08.09.09.jpeg');
            background-size: cover;
            background-position: center;
            min-height: calc(100vh - 78px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
        }
        .register-container {
            padding: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
            box-sizing: border-box;
        }
        .register-container h2 { margin-bottom: 20px; color: #333; }
        .register-container input, .register-container select { width: 100%; padding: 12px; box-sizing: border-box; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
        .register-container button { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .register-container .login-link { margin-top: 20px; display: block; }
        .site-footer{background-color:#222d3a;color:#cdd6e0;padding:45px 0 20px;font-size:15px;line-height:24px}.footer-container{width:90%;margin:0 auto}.footer-content{display:flex;flex-wrap:wrap;justify-content:space-between;margin-bottom:30px}.footer-column{width:23%;margin-bottom:20px}.footer-column h6{color:#fff;font-size:16px;text-transform:uppercase;margin-top:5px;letter-spacing:2px;margin-bottom:20px}.footer-column a,.footer-column p,.footer-column ul{margin:0;padding:0;list-style:none;color:#cdd6e0;text-decoration:none}.footer-column a:hover{color:#fff}.footer-column .fas{margin-right:10px}.footer-bottom{padding-top:20px;border-top:1px solid #454d58;display:flex;justify-content:space-between;align-items:center}.footer-social-media a{color:#cdd6e0;margin-left:15px;font-size:18px}.footer-social-media a:hover{color:#fff}
    </style>
</head>
<body>
    <header>
        <div class="top-bar"><div class="contact-info"><span><i class="fas fa-phone"></i> +62 823-1360-2560</span><span><i class="fas fa-envelope"></i> info@itpln.ac.id</span></div><div class="social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-youtube"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div>
    </header>
    
    <main class="main-container">
        <div class="register-container">
            <h2>Daftar Akun Baru</h2>
            <form action="register.php" method="POST">
                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                
                <select name="role" required>
                    <option value="" disabled selected>Pilih Role Anda</option>
                    <option value="ormawa">Ormawa</option>
                    <option value="bem_aset">BEM</option>
                </select>

                <input type="text" name="nama_ormawa" placeholder="Nama Ormawa (Contoh: BEM KBM, HMTI)" required>
                
                <button type="submit">Daftar</button>
            </form>
            <a href="login.php" class="login-link">Sudah punya akun? Kembali ke Login</a>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-container"><div class="footer-content"><div class="footer-column"><h6>Sarana & Fasilitas</h6><p><i class="fas fa-phone"></i> +62 2154-4034-2 (Abdul Haris)</p><p><i class="fas fa-envelope"></i> abdulharis@itpln.ac.id</p><p><i class="fas fa-map-marker-alt"></i> Sekretariat Lt. 11 IT-PLN, Duri Kosambi, Cengkareng, Jakarta Barat 11750</p></div><div class="footer-column"><h6>Biro BEM KBM</h6><p><i class="fas fa-envelope"></i> sekretarisbemkbmitpln@gmail.com</p><p><i class="fas fa-phone"></i> +62 895-0659-5952 (Foezy I.A.)</p></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">E-Learning</a></li><li><a href="#">Sistem Akademik</a></li><li><a href="#">Alumni</a></li></ul></div><div class="footer-column"><h6>Layanan</h6><ul><li><a href="#">Info Akademik</a></li><li><a href="#">Jurnal</a></li><li><a href="#">LPPM</a></li></ul></div></div><div class="footer-bottom"><div class="copyright-text"><p>Copyright &copy; 2025 All Rights Reserved by IT-PLN</p></div><div class="footer-social-media"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a></div></div></div>
    </footer>
</body>
</html>