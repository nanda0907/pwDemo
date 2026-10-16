// Jalankan kode setelah seluruh halaman selesai dimuat
document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // PENCARIAN DATA RUTINITAS
    // =========================

    // Ambil elemen dari halaman berdasarkan id
    const searchInput = document.getElementById("searchInput");
    const noResult = document.getElementById("noResult");
    const jumlahData = document.getElementById("jumlahData");

     // Hanya jalan kalau kotak pencarian ada (cuma di halaman daftar)
    if (searchInput) {
        searchInput.addEventListener("input", function () {

            // Ambil kata kunci: buang spasi pinggir, jadikan huruf kecil
            const keyword = searchInput.value.trim().toLowerCase();
            const rows = document.querySelectorAll("#rutinitasTable tbody tr"); // Ambil semua baris di isi tabel
            let found = 0;  // penghitung baris yang cocok

            rows.forEach(function (row) {

                const match = row.textContent.toLowerCase().includes(keyword);

                row.style.display = match ? "" : "none";

                if (match) {
                    found++;
                }
            });

            if (jumlahData) {
                jumlahData.textContent = found;
            }

            if (noResult) {
                noResult.hidden = found > 0;
            }
        });
    }


    // =========================
    // VALIDASI FORM (BOOTSTRAP)
    // =========================

    document.querySelectorAll(".needs-validation").forEach(function (form) {
        form.addEventListener("submit", function (event) {

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add("was-validated");
        });
    });

});