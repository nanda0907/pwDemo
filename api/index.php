<?php
$project_root = dirname(_DIR_);
$requested_path = $_GET['path'] ?? '';

$relative_path = ltrim(parse_url($requested_path, PHP_URL_PATH) ?? '', '/');

if ($relative_path === '' || $relative_path === 'index.php') {
    chdir($project_root);
    require $project_root . '/index.php';
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sudahLogin = isset($_SESSION['user_id']);

require_once "includes/koneksi.php";

$total = pg_fetch_assoc(
    pg_query($conn, "SELECT COUNT(*) AS total FROM rutinitas")
);

$pagi = pg_fetch_assoc(
    pg_query($conn, "SELECT COUNT(*) AS total FROM rutinitas WHERE waktu='Pagi'")
);

$malam = pg_fetch_assoc(
    pg_query($conn, "SELECT COUNT(*) AS total FROM rutinitas WHERE waktu='Malam'")
);

$page_title = "Beranda";
include "includes/header.php";
?>

<section class="hero rounded-4 p-4 p-md-5 mb-4 text-white">
    <h1 class="display-6 fw-bold">Selamat Datang di GlowTrack</h1>
    <p class="lead mb-4">
        Catat dan atur rutinitas skincare kamu setiap hari, pagi maupun malam.
    </p>

    <a href="<?= $base ?>rutinitas/daftar.php" class="btn btn-hero rounded-pill px-4 me-2 mb-2">Lihat Rutinitas</a>

    <?php if ($sudahLogin): ?>
        <a href="<?= $base ?>rutinitas/tambah.php"
           class="btn btn-hero rounded-pill px-4 mb-2">
            Tambah Produk
        </a>
    <?php else: ?>
        <a href="<?= $base ?>auth/login.php" class="btn btn-hero rounded-pill px-4 mb-2">Login untuk Mengelola</a>
    <?php endif; ?>
</section>

<h2 class="h4 fw-bold text-glow-dark mb-3">Ringkasan Rutinitas</h2>

<div class="row g-3">
    <div class="col-12 col-md-4">
        <div class="card stat-card stat-total border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="text-muted small">Total Rutinitas</div>
                <div class="stat-number"><?= $total['total'] ?></div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card stat-card stat-pagi border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="text-muted small">Rutinitas Pagi</div>
                <div class="stat-number"><?= $pagi['total'] ?></div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card stat-card stat-malam border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="text-muted small">Rutinitas Malam</div>
                <div class="stat-number"><?= $malam['total'] ?></div>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>