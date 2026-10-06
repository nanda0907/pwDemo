<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Buat token acak (sekali per sesi)
function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Tempel di dalam <form method="POST"> dengan: <?= csrf_field() 

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

// Panggil di awal setiap file proses_*.php
function csrf_verify()
{
    $token = $_POST['csrf_token'] ?? '';
    if ($token === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        die('Permintaan ditolak: token CSRF tidak valid atau kedaluwarsa.');
    }
}

?>