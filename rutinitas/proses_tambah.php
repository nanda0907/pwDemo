<?php
require_once "../includes/auth.php";
require_once "../includes/koneksi.php";

$produk = $_POST['produk'];
$kategori = $_POST['kategori'];
$waktu = $_POST['waktu'];
$urutan = (int)$_POST['urutan'];
$catatan = $_POST['catatan'];

$query = pg_query_params(
    $conn,
    "INSERT INTO rutinitas
    (produk, kategori, waktu, urutan, catatan)
    VALUES ($1, $2, $3, $4, $5)",
    [$produk, $kategori, $waktu, $urutan, $catatan]
);

if ($query) {
    $_SESSION['success'] = "Data berhasil ditambahkan!";
} else {
    $_SESSION['error'] = "Data gagal ditambahkan!";
}

header("Location: daftar.php");
exit;
?>