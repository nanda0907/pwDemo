<?php
session_start();
require_once "../includes/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$query = pg_query_params(
    $conn,
    "SELECT * FROM users WHERE username = $1",
    [$username]
);
$user = pg_fetch_assoc($query);

if ($user && password_verify($password, $user['password'])) {
    // Cegah session fixation
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama']    = $user['nama'];
    $_SESSION['role']    = $user['role'];
    $_SESSION['success'] = "Selamat datang, " . $user['nama'] . "!";

    header("Location: ../index.php");
    exit;
}

// Pesan sengaja umum: tidak membocorkan apakah username-nya ada atau tidak
$_SESSION['error'] = "Username atau password salah.";
header("Location: login.php");
exit;