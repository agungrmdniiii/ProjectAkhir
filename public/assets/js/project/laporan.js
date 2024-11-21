function downloadTableAsExcel() {
    const table = document.querySelector('table');
    const workbook = XLSX.utils.table_to_book(table);
    XLSX.writeFile(workbook, 'data_laporan.xlsx');
}

function showFeatureComingSoon() {
    alert("Fitur akan segera hadir");
}

function filterByYear(year) {
    // Get all rows in the table
    const rows = document.querySelectorAll('tbody tr');

    // Loop through each row
    rows.forEach(row => {
        const rowYear = row.getAttribute('data-year');

        // Show or hide rows based on the selected year
        if (year === "" || rowYear === year) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}