<?php
$project_root = dirname(__DIR__);
chdir($project_root);

$requested_path = trim((string) parse_url($_GET['path'] ?? '', PHP_URL_PATH), '/');

if ($requested_path !== '' && $requested_path !== 'index.php') {
    $page_path = realpath($project_root . DIRECTORY_SEPARATOR . $requested_path);
    $allowed_directories = [
        $project_root . DIRECTORY_SEPARATOR . 'auth' . DIRECTORY_SEPARATOR,
        $project_root . DIRECTORY_SEPARATOR . 'rutinitas' . DIRECTORY_SEPARATOR,
    ];
    $is_allowed_page = $page_path !== false
        && strtolower(pathinfo($page_path, PATHINFO_EXTENSION)) === 'php';

    if ($is_allowed_page) {
        $is_allowed_page = false;
        foreach ($allowed_directories as $directory) {
            if (str_starts_with($page_path, $directory)) {
                $is_allowed_page = true;
                break;
            }
        }
    }

    if (!$is_allowed_page) {
        http_response_code(404);
        exit('Not Found');
    }

    chdir(dirname($page_path));
    $_SERVER['SCRIPT_NAME'] = '/' . $requested_path;
    require $page_path;
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