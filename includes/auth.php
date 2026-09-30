<?php
// Guard: di-include di BARIS PALING ATAS halaman yang wajib login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Silakan login terlebih dahulu.";
    header("Location: ../auth/login.php");
    exit;
}