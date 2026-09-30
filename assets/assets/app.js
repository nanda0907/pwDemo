document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // PENCARIAN DATA RUTINITAS
    // =========================

    const searchInput = document.getElementById("searchInput");
    const noResult = document.getElementById("noResult");
    const jumlahData = document.getElementById("jumlahData");

    if (searchInput) {
        searchInput.addEventListener("input", function () {

            const keyword = searchInput.value.trim().toLowerCase();
            const rows = document.querySelectorAll("#rutinitasTable tbody tr");
            let found = 0;

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