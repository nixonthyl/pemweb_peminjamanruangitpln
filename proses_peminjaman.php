<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
// Saya asumsikan ID user disimpan di $_SESSION['id_user'] setelah login berhasil.
// Ganti 'id_user' sesuai dengan nama session yang Anda gunakan.
if (!isset($_SESSION['id_user'])) {
    die("Error: Anda harus login untuk melakukan peminjaman.");
}

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Ambil data dari form dengan aman
    $id_user_pengaju = $_SESSION['id_user'];
    $id_ruangan = $_POST['id_ruangan']; // Ini didapat dari hidden input di form
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $keperluan = $_POST['keperluan'];
    $surat_permohonan = $_POST['surat_permohonan']; // Opsional, sesuaikan dengan form

    // Default status bisa di-set di sini atau dibiarkan default dari database
    $status_aset = 'pending';
    $status_bkmk = 'menunggu';

    // Query INSERT menggunakan prepared statement untuk keamanan
    $sql = "INSERT INTO peminjaman (id_user_pengaju, id_ruangan, tanggal, jam_mulai, jam_selesai, keperluan, surat_permohonan, status_aset, status_bkmk) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        // Bind parameter ke query
        mysqli_stmt_bind_param($stmt, "iisssssss", 
            $id_user_pengaju, 
            $id_ruangan, 
            $tanggal, 
            $jam_mulai, 
            $jam_selesai, 
            $keperluan, 
            $surat_permohonan, 
            $status_aset, 
            $status_bkmk
        );

        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, arahkan ke halaman status ruangan
            header("Location: statusruangan.php?status=sukses");
            exit();
        } else {
            // Jika gagal
            die("Error: Gagal menyimpan data. " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Error: Gagal mempersiapkan statement. " . mysqli_error($koneksi));
    }
    
    mysqli_close($koneksi);

} else {
    // Jika bukan POST, redirect ke halaman utama
    header("Location: index.php");
    exit();
}
?>