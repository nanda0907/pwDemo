<?php
require_once "../includes/koneksi.php";
$query = pg_query(
    $conn,
    "SELECT * FROM rutinitas ORDER BY waktu, urutan, id"
);

$rows  = pg_fetch_all($query) ?: [];
$total = count($rows);

$page_title = "Daftar Rutinitas";
include "../includes/header.php";
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
        <h2 class="h3 fw-bold text-glow-dark mb-0">Daftar Rutinitas</h2>
        <p class="text-muted mb-0">Kelola semua produk skincare kamu di sini.</p>
    </div>
    <!-- <a href="tambah.php" class="btn btn-primary rounded-pill px-4">+ Tambah Produk</a> -->
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-3 p-md-4">

        <?php if ($total === 0): ?>

            <div class="text-center py-5">
                <p class="text-muted mb-3">Belum ada produk. Yuk tambah yang pertama!</p>
                <a href="tambah.php" class="btn btn-primary rounded-pill px-4">+ Tambah Produk</a>
            </div>

        <?php else: ?>

            <div class="row g-2 align-items-center mb-3">
                <div class="col-12 col-md-6 col-lg-5">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari produk, kategori, waktu, atau catatan..." autocomplete="off">
                </div>

                <div class="col text-md-end text-muted small">
                    Menampilkan <strong id="jumlahData"><?= $total ?></strong>
                    dari <?= $total ?> produk
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0" id="rutinitasTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Waktu</th>
                            <th class="text-center">Urutan</th>
                            <th>Catatan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($rows as $i => $row): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>

                            <td class="fw-semibold">
                                <?= htmlspecialchars($row['produk']) ?>
                            </td>

                            <td><?= htmlspecialchars($row['kategori']) ?></td>

                            <td><?= htmlspecialchars($row['waktu']) ?></td>

                            <td class="text-center"><?= (int)$row['urutan'] ?></td>

                            <td class="text-muted">
                                <?= htmlspecialchars($row['catatan'] ?? '') ?>
                            </td>

                            <td class="text-end text-nowrap">
                                <a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-outline-warning">Edit</a>

                                <form method="POST" action="hapus.php" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">

                                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div id="noResult" class="text-center text-muted py-4" hidden>
                Tidak ada produk yang cocok dengan pencarianmu.
            </div>

        <?php endif; ?>

    </div>
</div>

<?php include "../includes/footer.php"; ?>