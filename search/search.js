function searchKaryawan() {
    const searchTerm = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll("tbody tr");
    let noDataAvailable = true;

    rows.forEach((row) => {
        const namaCell = row.querySelector("td:nth-child(2)");

        if (namaCell) {
        const nama = namaCell.textContent.toLowerCase();
        if (nama.includes(searchTerm)) {
            row.style.display = "";
            noDataAvailable = false;
        } else {
            row.style.display = "none";
        }
        }
    });

    const noDataMessage = document.getElementById("noDataMessage");
    if (noDataAvailable) {
        noDataMessage.style.display = "table-row";
    } else {
        noDataMessage.style.display = "none";
    }
}

// Fungsi yang akan dijalankan saat pengguna berhenti mengetik
function delayedSearch() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(searchKaryawan, 50);
}

// let timeoutId;
// const searchInput = document.querySelector(".form-control");
// searchInput.addEventListener("input", delayedSearch);
// searchKaryawan();


