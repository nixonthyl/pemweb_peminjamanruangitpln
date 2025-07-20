<?php
session_start();
include 'koneksi.php';

// Pastikan ada data yang dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email']; 
    $password = $_POST['password'];

    $sql = "SELECT id_user, nama_lengkap, email, password, role FROM users WHERE email = ?";
    
    if($stmt = $koneksi->prepare($sql)){
        $stmt->bind_param("s", $email);
        
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                $user = $result->fetch_assoc();
                
                if(password_verify($password, $user['password'])){
                    // ### SOLUSINYA DI SINI ###
                    // Membuat session baru yang bersih dan menghapus yang lama
                    session_regenerate_id(true);

                    // Buat session baru
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id_user'] = $user['id_user'];
                    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                    $_SESSION['role'] = $user['role'];

                    // Arahkan berdasarkan role
                    if ($user['role'] == 'bkmk') {
                        header("location: admin.php");
                    } else {
                        header("location: form-peminjaman.php");
                    }
                    exit;

                } else {
                    header("location: login.php?error=1");
                    exit;
                }
            } else {
                header("location: login.php?error=1");
                exit;
            }
        }
        $stmt->close();
    }
    $koneksi->close();
} else {
    header("Location: login.php");
    exit;
}
?>