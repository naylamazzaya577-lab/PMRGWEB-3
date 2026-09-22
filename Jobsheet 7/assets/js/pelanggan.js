document.addEventListener("DOMContentLoaded", () => {
    fetchPelangganData();
});

async function fetchPelangganData() {
    const tbody = document.querySelector("#tabelPelanggan tbody");
    if (!tbody) return;

    try {
        const res = await fetch("../data/pelanggan.json");
        const data = await res.json();
        
        tbody.innerHTML = data.map(c => `
            <tr class="hover:bg-zinc-900/50 transition-colors">
                <td class="px-6 py-4 font-mono text-zinc-400">${c.kode_pelanggan}</td>
                <td class="px-6 py-4 font-medium text-white">${c.nama}</td>
                <td class="px-6 py-4 text-zinc-400">${c.alamat}</td>
                <td class="px-6 py-4 font-mono text-zinc-400">${c.no_hp}</td>
            </tr>
        `).join("");
    } catch (e) {
        tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-red-400">Gagal memuat data pelanggan.</td></tr>`;
    }
}