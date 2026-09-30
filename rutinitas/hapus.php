<?php
require_once "../includes/auth.php";
require_once "../includes/koneksi.php";

// Hanya menerima POST (dari tombol Hapus di daftar.php)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: daftar.php");
    exit;
}

$id = (int)($_POST['id'] ?? 0);

$query = pg_query_params(
    $conn,
    "DELETE FROM rutinitas WHERE id = $1",
    [$id]
);

if ($query) {
    $_SESSION['success'] = "Data berhasil dihapus!";
} else {
    $_SESSION['error'] = "Data gagal dihapus!";
}

header("Location: daftar.php");
exit;
?>