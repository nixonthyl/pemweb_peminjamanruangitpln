<?php
// 1. Mulai session
session_start();

// 2. Kosongkan semua variabel session
$_SESSION = array();

// 3. Hancurkan session
session_destroy();

// 4. Arahkan pengguna kembali ke halaman login
header("location: login.php");
exit;
?>