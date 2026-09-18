document.addEventListener("DOMContentLoaded", () => {
    initNavbar();
    initValidasiForm();
    initTableFilter();
    initDeleteAction();
});

/* 1. Hamburger Menu Toggle */
function initNavbar() {
    const toggler = document.querySelector(".navbar-toggler");
    const nav = document.querySelector(".navbar");

    if (toggler && nav) {
        toggler.addEventListener("click", () => {
            nav.classList.toggle("nav-open");
        });
    }
}

/* 2. Validasi Form Client-Side (Inline Error) */
function initValidasiForm() {
    const form = document.querySelector("form");
    if (!form) return;

    form.addEventListener("submit", (e) => {
        let isValid = true;
        
        // Hapus pesan error lama
        document.querySelectorAll(".error-msg").forEach(el => el.remove());

        // Helper untuk tampilkan error inline via DOM manipulation
        const showError = (input, message) => {
            isValid = false;
            const error = document.createElement("div");
            error.className = "error-msg text-danger small mt-1";
            error.textContent = message;
            input.insertAdjacentElement("afterend", error);
        };

        // Validasi field wajib (required)
        const requiredInputs = form.querySelectorAll("[required]");
        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                showError(input, "Field ini wajib diisi!");
            }
        });

        // Validasi rentang tahun (1900 - 2026)
        const tahunInput = document.getElementById("tahun");
        if (tahunInput && tahunInput.value) {
            const tahun = parseInt(tahunInput.value);
            if (tahun < 1900 || tahun > 2026) {
                showError(tahunInput, "Tahun harus di antara 1900 - 2026!");
            }
        }

        // Validasi stok non-negatif (>= 0)
        const stokInput = document.getElementById("stok");
        if (stokInput && stokInput.value !== "") {
            if (parseInt(stokInput.value) < 0) {
                showError(stokInput, "Stok tidak boleh negatif!");
            }
        }

        if (!isValid) {
            e.preventDefault(); // Batalkan submit jika validasi gagal
        }
    });
}

/* 3. Pencarian Tabel Real-Time */
function initTableFilter() {
    const filterInput = document.getElementById("cariInput");
    const tableBody = document.querySelector("table tbody");

    if (!filterInput || !tableBody) return;

    filterInput.addEventListener("keyup", () => {
        const keyword = filterInput.value.toLowerCase();
        const rows = tableBody.querySelectorAll("tr");

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(keyword) ? "" : "none";
        });
    });
}

/* 4. Hapus Baris Tabel via Front-End */
function initDeleteAction() {
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("btn-hapus")) {
            const setuju = confirm("Apakah Anda yakin ingin menghapus data ini?");
            if (setuju) {
                const row = e.target.closest("tr");
                if (row) row.remove();
            }
        }
    });
}