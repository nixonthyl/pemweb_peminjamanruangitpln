<?php
$koneksi = new mysqli("localhost", "root", "", "pemweb_peminjamanruangitpln_kel4", 3308);
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
