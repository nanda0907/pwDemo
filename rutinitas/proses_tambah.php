<?php
require_once "../includes/auth.php";      // 1. guard: harus login
require_once "../includes/csrf.php";      // 2. fungsi token
require_once "../includes/helpers.php";   // 3. fungsi validasi
require_once "../includes/koneksi.php";

csrf_verify();                            // 4. tolak kalau token salah

[$data, $errors] = validasi_rutinitas($_POST);

if ($errors) {
    $_SESSION['error'] = implode(' ', $errors);
    header("Location: tambah.php");
    exit;
}

$query = pg_query_params(
    $conn,
    "INSERT INTO rutinitas (produk, kategori, waktu, urutan, catatan)
     VALUES ($1, $2, $3, $4, $5)",
    [$data['produk'], $data['kategori'], $data['waktu'], $data['urutan'], $data['catatan']]
);

if ($query) {
    $_SESSION['success'] = "Data berhasil ditambahkan!";
} else {
    $_SESSION['error'] = "Data gagal ditambahkan!";
}

header("Location: daftar.php");
exit;