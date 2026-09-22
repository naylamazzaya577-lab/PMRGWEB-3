document.addEventListener("DOMContentLoaded", () => {
    fetchProdukData();
});

async function fetchProdukData() {
    const tbody = document.querySelector("#tabelProduk tbody");
    if (!tbody) return;

    try {
        const res = await fetch("../data/produk.json");
        const data = await res.json();
        
        tbody.innerHTML = data.map(p => `
            <tr class="hover:bg-zinc-900/50 transition-colors">
                <td class="px-6 py-4 font-mono text-zinc-400">${p.kode_produk}</td>
                <td class="px-6 py-4 font-medium text-white">${p.nama_produk}</td>
                <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-xs bg-zinc-800 text-zinc-300 border border-zinc-700">${p.kategori}</span></td>
                <td class="px-6 py-4 font-mono">Rp ${p.harga.toLocaleString("id-ID")}</td>
                <td class="px-6 py-4 font-mono">${p.stok}</td>
            </tr>
        `).join("");
    } catch (e) {
        tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-red-400">Gagal memuat data produk.</td></tr>`;
    }
}