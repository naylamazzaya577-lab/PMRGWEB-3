document.addEventListener("DOMContentLoaded", () => {
    if (window.lucide) {
        lucide.createIcons();
    }
    initFormHandlers();
});

function initFormHandlers() {
    const formProduk = document.getElementById("formProduk");
    if (formProduk) {
        formProduk.addEventListener("submit", (e) => {
            e.preventDefault();
            alert("Produk berhasil ditambahkan!");
            window.location.href = "ListProduk.html";
        });
    }

    const formPelanggan = document.getElementById("formPelanggan");
    if (formPelanggan) {
        formPelanggan.addEventListener("submit", (e) => {
            e.preventDefault();
            alert("Pelanggan berhasil ditambahkan!");
            window.location.href = "ListPelanggan.html";
        });
    }
}