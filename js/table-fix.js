document.addEventListener('DOMContentLoaded', function() {
    console.log('Table fix script loaded');
    
    // Check if the CSS is loaded
    const cssLoaded = Array.from(document.styleSheets).some(sheet => {
        try {
            // Check if sheet URL contains our CSS filename
            return sheet.href && sheet.href.includes('shared-tables.css');
        } catch (e) {
            return false;
        }
    });
    
    console.log('Shared table CSS loaded:', cssLoaded);
    
    // Apply table styles directly if issues persist
    if (!cssLoaded || document.querySelector('.msa-table') && !getComputedStyle(document.querySelector('.msa-table')).backgroundColor) {
        console.log('Applying table styles via JavaScript');
        
        // Apply styles to all MSA tables
        const tables = document.querySelectorAll('.msa-table');
        tables.forEach(table => {
            table.style.width = '100%';
            table.style.borderCollapse = 'separate';
            table.style.borderSpacing = '0';
            table.style.fontFamily = "'Noto Naskh Arabic', serif";
            table.style.backgroundColor = '#ffffff';
            
            // Style table headers
            const headers = table.querySelectorAll('thead th');
            headers.forEach(header => {
                header.style.backgroundColor = '#1a541c';
                header.style.color = '#ffffff';
                header.style.fontWeight = '600';
                header.style.textTransform = 'uppercase';
                header.style.padding = '16px 20px';
                header.style.textAlign = 'left';
                header.style.position = 'sticky';
                header.style.top = '0';
                header.style.zIndex = '10';
                header.style.letterSpacing = '0.5px';
                header.style.fontSize = '0.9rem';
                header.style.border = 'none';
            });
            
            // Style table rows
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.transition = 'background-color 0.2s ease';
                
                if (index % 2 === 0) {
                    row.style.backgroundColor = '#ffffff';
                } else {
                    row.style.backgroundColor = '#f8f9fa';
                }
                
                // Add hover effect
                row.addEventListener('mouseover', function() {
                    this.style.backgroundColor = '#f0f7f0';
                });
                
                row.addEventListener('mouseout', function() {
                    if (index % 2 === 0) {
                        this.style.backgroundColor = '#ffffff';
                    } else {
                        this.style.backgroundColor = '#f8f9fa';
                    }
                });
            });
            
            // Style table cells
            const cells = table.querySelectorAll('tbody td');
            cells.forEach(cell => {
                cell.style.padding = '15px 20px';
                cell.style.color = '#333333';
                cell.style.borderBottom = '1px solid #eaecef';
                cell.style.fontSize = '0.95rem';
            });
            
            // Style total rows
            const totalRows = table.querySelectorAll('tr.total-row');
            totalRows.forEach(row => {
                row.style.backgroundColor = '#e8f3e8';
                row.style.fontWeight = 'bold';
                
                const totalCells = row.querySelectorAll('td');
                totalCells.forEach(cell => {
                    cell.style.borderTop = '2px solid #1a541c';
                    cell.style.color = '#1a541c';
                });
            });
        });
        
        // Style table containers
        const containers = document.querySelectorAll('.table-container');
        containers.forEach(container => {
            container.style.width = '100%';
            container.style.margin = '0 auto 30px';
            container.style.borderRadius = '10px';
            container.style.boxShadow = '0 2px 15px rgba(0, 0, 0, 0.1)';
            container.style.overflow = 'hidden';
            container.style.backgroundColor = '#ffffff';
        });
    }
}); 