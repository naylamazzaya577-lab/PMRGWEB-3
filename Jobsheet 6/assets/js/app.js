document.addEventListener("DOMContentLoaded", () => {
    initNavbar();
    initValidasiForm();
    initTableFilter();
    initHapusConfirm();
});

function initNavbar() {
    const toggler = document.querySelector(".navbar-toggler");
    const nav = document.querySelector(".navbar");
    if (toggler && nav) {
        toggler.addEventListener("click", () => nav.classList.toggle("nav-open"));
    }
}

function initValidasiForm() {
    const form = document.querySelector("form");
    if (!form) return;

    form.addEventListener("submit", (e) => {
        let isValid = true;
        document.querySelectorAll(".error-msg").forEach(el => el.remove());

        const showError = (input, message) => {
            isValid = false;
            const error = document.createElement("div");
            error.className = "error-msg text-danger small mt-1";
            error.textContent = message;
            input.insertAdjacentElement("afterend", error);
        };

        form.querySelectorAll("[required]").forEach(input => {
            if (!input.value.trim()) showError(input, "Field ini wajib diisi!");
        });

        const tahunInput = document.getElementById("tahun");
        if (tahunInput && tahunInput.value) {
            const tahun = parseInt(tahunInput.value);
            if (tahun < 1900 || tahun > 2026) showError(tahunInput, "Tahun harus di antara 1900 - 2026!");
        }

        const stokInput = document.getElementById("stok");
        if (stokInput && stokInput.value !== "") {
            if (parseInt(stokInput.value) < 0) showError(stokInput, "Stok tidak boleh negatif!");
        }

        if (!isValid) e.preventDefault();
    });
}

function initTableFilter() {
    const filterInput = document.getElementById("cariInput");
    if (!filterInput) return;

    filterInput.addEventListener("keyup", () => {
        const keyword = filterInput.value.toLowerCase();
        const rows = document.querySelectorAll("table tbody tr");
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(keyword) ? "" : "none";
        });
    });
}

/* Event Delegation untuk Tombol Hapus */
function initHapusConfirm() {
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("btn-hapus")) {
            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                const row = e.target.closest("tr");
                if (row) row.remove();
            }
        }
    });
}