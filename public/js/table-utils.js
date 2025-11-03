// Table filtering and export utilities
class TableUtils {
    static initializeTable(tableId) {
        const table = document.getElementById(tableId);
        if (!table) return;

        // Add filter inputs to table headers
        this.addFilterInputs(table);
        
        // Add export button
        this.addExportButton(table);
        
        // Initialize filtering
        this.initializeFiltering(table);
    }

    static addFilterInputs(table) {
        const thead = table.querySelector('thead');
        const headerRow = thead.querySelector('tr');
        const filterRow = document.createElement('tr');
        
        headerRow.querySelectorAll('th').forEach((th, index) => {
            const filterTh = document.createElement('th');
            if (index < headerRow.children.length - 1) { // Skip actions column
                filterTh.innerHTML = `<input type="text" class="form-control form-control-sm filter-input" placeholder="Filter..." data-column="${index}">`;
            }
            filterRow.appendChild(filterTh);
        });
        
        thead.appendChild(filterRow);
    }

    static addExportButton(table) {
        const container = table.closest('.card');
        if (!container) return;
        
        const header = container.querySelector('.card-header, .d-flex');
        if (header) {
            const exportBtn = document.createElement('button');
            exportBtn.className = 'btn btn-success btn-sm ms-2';
            exportBtn.innerHTML = '<i class="fas fa-file-excel"></i> Export Excel';
            exportBtn.onclick = () => this.exportToExcel(table);
            header.appendChild(exportBtn);
        }
    }

    static initializeFiltering(table) {
        const filterInputs = table.querySelectorAll('.filter-input');
        const tbody = table.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr');

        filterInputs.forEach(input => {
            input.addEventListener('input', () => {
                const filters = Array.from(filterInputs).map(inp => ({
                    column: parseInt(inp.dataset.column),
                    value: inp.value.toLowerCase()
                }));

                rows.forEach(row => {
                    let show = true;
                    filters.forEach(filter => {
                        if (filter.value && row.cells[filter.column]) {
                            const cellText = row.cells[filter.column].textContent.toLowerCase();
                            if (!cellText.includes(filter.value)) {
                                show = false;
                            }
                        }
                    });
                    row.style.display = show ? '' : 'none';
                });
            });
        });
    }

    static exportToExcel(table) {
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.table_to_sheet(table, {
            raw: false,
            dateNF: 'yyyy-mm-dd'
        });
        
        XLSX.utils.book_append_sheet(wb, ws, 'Data');
        XLSX.writeFile(wb, `export_${new Date().toISOString().split('T')[0]}.xlsx`);
    }
}

// Auto-initialize tables on page load
document.addEventListener('DOMContentLoaded', function() {
    const tables = document.querySelectorAll('table');
    tables.forEach((table, index) => {
        if (!table.id) table.id = `data-table-${index}`;
        TableUtils.initializeTable(table.id);
    });
});