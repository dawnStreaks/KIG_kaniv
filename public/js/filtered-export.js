// Filtered Export Utility
class FilteredExport {
    static initializeExportButton(tableId, exportUrl) {
        const table = document.getElementById(tableId);
        if (!table) return;

        // Find export button and add click handler
        const exportBtn = document.querySelector(`[href="${exportUrl}"]`);
        if (exportBtn) {
            exportBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.exportWithFilters(exportUrl, tableId);
            });
        }
    }

    static exportWithFilters(baseUrl, tableId) {
        const table = document.getElementById(tableId);
        const filterInputs = table.querySelectorAll('.filter-input, thead tr:nth-child(2) input, thead tr:nth-child(2) select');
        const visibleRows = Array.from(table.querySelectorAll('tbody tr')).filter(row => 
            row.style.display !== 'none'
        );

        // Get filter parameters
        const params = new URLSearchParams();
        filterInputs.forEach((input, index) => {
            if (input.value) {
                params.append(`filter_${index}`, input.value);
            }
        });

        // Get visible row IDs if available
        const visibleIds = visibleRows.map(row => {
            const firstCell = row.cells[0];
            return firstCell ? firstCell.textContent.trim() : null;
        }).filter(id => id && !isNaN(id));

        if (visibleIds.length > 0) {
            params.append('ids', visibleIds.join(','));
        }

        // Create download link
        const url = `${baseUrl}?${params.toString()}`;
        window.location.href = url;
    }

    static clearFilters(tableId) {
        const table = document.getElementById(tableId);
        const filterInputs = table.querySelectorAll('.filter-input, thead tr:nth-child(2) input, thead tr:nth-child(2) select');
        filterInputs.forEach(input => {
            input.value = '';
            input.dispatchEvent(new Event('input'));
        });
    }
}

// Global function for clear filters button
function clearFilters() {
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        if (table.id) {
            FilteredExport.clearFilters(table.id);
        }
    });
}