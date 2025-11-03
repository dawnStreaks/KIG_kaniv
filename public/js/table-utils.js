// Excel export utility
class TableUtils {

    static addExportButton(table) {
        const container = table.closest('.card') || table.parentElement;
        let header = container.querySelector('.d-flex, .card-header');
        
        if (!header) {
            header = container.querySelector('h2, h3, h4, h5, h6')?.parentElement;
        }
        
        if (header && !header.querySelector('.export-excel-btn')) {
            const exportBtn = document.createElement('button');
            exportBtn.className = 'btn btn-success btn-sm ms-2 export-excel-btn';
            exportBtn.innerHTML = '<i class="fas fa-file-excel"></i> Export Excel';
            exportBtn.onclick = () => this.exportToExcel(table);
            header.appendChild(exportBtn);
        }
    }

    static exportToExcel(table) {
        const tableClone = table.cloneNode(true);
        const filterRows = tableClone.querySelectorAll('tr:has(.filter-input)');
        filterRows.forEach(row => row.remove());
        
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.table_to_sheet(tableClone, {
            raw: false,
            dateNF: 'yyyy-mm-dd'
        });
        
        XLSX.utils.book_append_sheet(wb, ws, 'Data');
        XLSX.writeFile(wb, `export_${new Date().toISOString().split('T')[0]}.xlsx`);
    }
}

// Auto-add export buttons to all tables
document.addEventListener('DOMContentLoaded', function() {
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        TableUtils.addExportButton(table);
    });
});