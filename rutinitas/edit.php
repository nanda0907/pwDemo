<?php
require_once "../includes/auth.php";
require_once "../includes/koneksi.php";

$id = (int)$_GET['id'];

$query = pg_query_params(
    $conn,
    "SELECT * FROM rutinitas WHERE id = $1",
    [$id]
);

$data = pg_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan.");
}

$kategoriList = [
    "Cleanser", "Toner", "Serum",
    "Moisturizer", "Sunscreen", "Lainnya"
];

include "../includes/header.php";
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <h2 class="h4 fw-bold text-glow-dark mb-4">
                    <i class="bi bi-pencil-square me-2"></i>Edit Rutinitas
                </h2>

                <form action="proses_edit.php" method="POST" class="needs-validation" novalidate>

                    <input type="hidden" name="id" value="<?= $data['id'] ?>">

                    <div class="mb-3">
                        <label for="produk" class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" class="form-control" id="produk" name="produk" value="<?= htmlspecialchars($data['produk']) ?>" required>
                        <div class="invalid-feedback">Nama produk harus diisi.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="kategori" class="form-label fw-semibold">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <?php foreach ($kategoriList as $kategori): ?>
                                    <option value="<?= $kategori ?>"
                                        <?= $data['kategori'] == $kategori ? 'selected' : '' ?>>
                                        <?= $kategori ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="waktu" class="form-label fw-semibold">Waktu</label>
                            <select class="form-select" id="waktu" name="waktu" required>
                                <option value="Pagi"
                                    <?= $data['waktu'] == 'Pagi' ? 'selected' : '' ?>>Pagi</option>
                                <option value="Malam"
                                    <?= $data['waktu'] == 'Malam' ? 'selected' : '' ?>>Malam</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="urutan" class="form-label fw-semibold">Urutan Pemakaian</label>
                            <input type="number" class="form-control" id="urutan" name="urutan" value="<?= (int)$data['urutan'] ?>" min="1" required>
                            <div class="invalid-feedback">Urutan harus lebih dari 0.</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="catatan" class="form-label fw-semibold">Catatan</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3"><?= htmlspecialchars($data['catatan'] ?? '') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="daftar.php" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i>Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>