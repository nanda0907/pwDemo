<?php
// Escape output: <script> jadi teks biasa, bukan kode yang dijalankan browser
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

// Validasi server-side untuk form tambah & edit rutinitas
// Mengembalikan [data_bersih, daftar_error]
function validasi_rutinitas(array $in): array
{
    $kategoriValid = ['Cleanser', 'Toner', 'Serum', 'Moisturizer', 'Sunscreen', 'Lainnya'];
    $waktuValid    = ['Pagi', 'Malam'];

    $data = [
        'produk'   => trim($in['produk'] ?? ''),
        'kategori' => $in['kategori'] ?? '',
        'waktu'    => $in['waktu'] ?? '',
        'urutan'   => $in['urutan'] ?? '',
        'catatan'  => trim($in['catatan'] ?? ''),
    ];

    $errors = [];

    // Ubah angka 100 sesuai panjang kolom "produk" di tabelmu
    if ($data['produk'] === '' || mb_strlen($data['produk']) > 100) {
        $errors[] = "Nama produk wajib diisi (maksimal 100 karakter).";
    }
    if (!in_array($data['kategori'], $kategoriValid, true)) {
        $errors[] = "Kategori tidak valid.";
    }
    if (!in_array($data['waktu'], $waktuValid, true)) {
        $errors[] = "Waktu pemakaian tidak valid.";
    }
    if (!is_numeric($data['urutan']) || (int) $data['urutan'] < 1) {
        $errors[] = "Urutan harus berupa angka minimal 1.";
    }
    $data['urutan'] = (int) $data['urutan'];

    return [$data, $errors];
}