<?php
require_once "../includes/auth.php";
require_once "../includes/koneksi.php";

$id = (int)$_POST['id'];

$produk = $_POST['produk'];
$kategori = $_POST['kategori'];
$waktu = $_POST['waktu'];
$urutan = (int)$_POST['urutan'];
$catatan = $_POST['catatan'];

$query = pg_query_params(
    $conn,
    "UPDATE rutinitas
     SET produk=$1,
         kategori=$2,
         waktu=$3,
         urutan=$4,
         catatan=$5
     WHERE id=$6",
    [$produk, $kategori, $waktu, $urutan, $catatan, $id]
);

if ($query) {
    $_SESSION['success'] = "Data berhasil diubah!";
} else {
    $_SESSION['error'] = "Data gagal diubah!";
}

header("Location: daftar.php");
exit;
?>