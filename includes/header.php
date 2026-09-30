<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sudahLogin = isset($_SESSION['user_id']);

$base = "/PEMOGRAMAN-WEB/skincare-routine/";

// Menandai menu yang sedang aktif
$current = basename($_SERVER['SCRIPT_NAME']);
$isActive = function (array $pages) use ($current) {
    return in_array($current, $pages) ? 'active' : '';
};
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Glow<?= isset($page_title) ? ' | ' . $page_title : '' ?></title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS tema pink -->
    <link rel="stylesheet" href="<?= $base ?>assets/assets/style.css?v=9">  
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">

            <a class="navbar-brand fw-bold" href="<?= $base ?>index.php">
                GlowTrack
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarMenu"
                    aria-controls="navbarMenu"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link <?= $isActive(['index.php']) ?>"
                           href="<?= $base ?>index.php">Beranda</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= $isActive(['daftar.php', 'edit.php']) ?>"
                           href="<?= $base ?>rutinitas/daftar.php">Daftar Rutinitas</a>
                    </li>

                    <?php if ($sudahLogin): ?>
                        <!-- <li class="nav-item">
                            <a class="nav-link <?= $isActive(['tambah.php']) ?>"
                               href="<?= $base ?>rutinitas/tambah.php">Tambah Rutinitas</a>
                        </li> -->

                        <!-- <li class="nav-item d-flex align-items-center">
                            <span class="navbar-text text-white ms-md-3 me-md-2">
                                Hai, <?= htmlspecialchars($_SESSION['nama']) ?>
                            </span>
                        </li> -->
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $base ?>auth/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $isActive(['login.php']) ?>"
                               href="<?= $base ?>auth/login.php">Login</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

        </div>
    </nav>

    <main class="container py-4 flex-grow-1">

        <!-- Pesan notifikasi -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>