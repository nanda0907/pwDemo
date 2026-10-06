<?php
require_once "../includes/auth.php";
require_once "../includes/csrf.php";
require_once "../includes/helpers.php";
require_once "../includes/koneksi.php";

csrf_verify();

$id = (int)($_POST['id'] ?? 0);
[$data, $errors] = validasi_rutinitas($_POST);

if ($id < 1) {
    $_SESSION['error'] = "ID tidak valid.";
    header("Location: daftar.php");
    exit;
}

if ($errors) {
    $_SESSION['error'] = implode(' ', $errors);
    header("Location: edit.php?id=" . $id);
    exit;
}

$query = pg_query_params(
    $conn,
    "UPDATE rutinitas
     SET produk=$1,
         kategori=$2,
         waktu=$3,
         urutan=$4,
         catatan=$5
     WHERE id=$6",
    [$data['produk'], $data['kategori'], $data['waktu'], $data['urutan'], $data['catatan'], $id]
);

if ($query) {
    $_SESSION['success'] = "Data berhasil diubah!";
} else {
    $_SESSION['error'] = "Data gagal diubah!";
}

header("Location: daftar.php");
exit;