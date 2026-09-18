document.addEventListener("DOMContentLoaded", () => {
    loadDataAnggota();
});

async function loadDataAnggota() {
    const tableBody = document.querySelector("#tabelAnggota tbody");
    const loading = document.getElementById("loading-indicator");

    if (!tableBody) return;

    try {
        if (loading) loading.classList.remove("d-none");

        // Simulasi delay 600ms
        await new Promise(resolve => setTimeout(resolve, 600));

        const response = await fetch("../data/anggota.json");
        if (!response.ok) throw new Error(`HTTP Error! Status: ${response.status}`);

        const data = await response.json();
        tableBody.innerHTML = "";

        data.forEach(anggota => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${anggota.no_anggota}</td>
                <td>${anggota.nama}</td>
                <td>${anggota.alamat}</td>
                <td>${anggota.no_hp}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm btn-hapus">Hapus</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } catch (error) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-danger py-3">
                    Gagal memuat data anggota: ${error.message}
                </td>
            </tr>
        `;
    } finally {
        if (loading) loading.classList.add("d-none");
    }
}