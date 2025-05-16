$(document).ready(function() {
    // Save initial filter values
    let savedFilters = {
        schoolYearId: $('#filterSchoolYear').val(),
        semester: $('#filterSemester').val(),
        startDate: $('#filterStartDate').val(),
        endDate: $('#filterEndDate').val()
    };
    
    // Initialize DataTables with better column configurations
    if (!$.fn.DataTable.isDataTable('#cashinTable')) {
        $('#cashinTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            columnDefs: [
                {
                    targets: 0, // Date column
                    render: function(data, type, row) {
                        // For ordering, sorting, etc. use the data-order value
                        if (type === 'sort' || type === 'type') {
                            return $(data).attr('data-order') || '';
                        }
                        // For display or filter, just return the HTML
                        return data;
                    }
                },
                {
                    targets: 5, // Action column
                    orderable: false
                }
            ],
            createdRow: function(row, data, dataIndex) {
                // This runs after each row is created
                // Make sure the first cell has a data-order attribute
                if (typeof data[0] === 'string' && data[0].includes('<td data-order')) {
                    // If it's already HTML with a td tag, use it directly (this is our case)
                    $(row).find('td:eq(0)').replaceWith(data[0]);
                }
            }
        });
    }
    
    if (!$.fn.DataTable.isDataTable('#cashoutTable')) {
        $('#cashoutTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            columnDefs: [
                {
                    targets: 0, // Date column
                    render: function(data, type, row) {
                        // For ordering, sorting, etc. use the data-order value
                        if (type === 'sort' || type === 'type') {
                            return $(data).attr('data-order') || '';
                        }
                        // For display or filter, just return the HTML
                        return data;
                    }
                },
                {
                    targets: 5, // Action column
                    orderable: false
                }
            ],
            createdRow: function(row, data, dataIndex) {
                // This runs after each row is created
                // Make sure the first cell has a data-order attribute
                if (typeof data[0] === 'string' && data[0].includes('<td data-order')) {
                    // If it's already HTML with a td tag, use it directly (this is our case)
                    $(row).find('td:eq(0)').replaceWith(data[0]);
                }
            }
        });
    }
    
    // Prevent default behavior on filter changes to avoid form resets
    $('#filterSchoolYear, #filterSemester, #filterStartDate, #filterEndDate').on('change', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Save the values immediately when changed
        savedFilters.schoolYearId = $('#filterSchoolYear').val();
        savedFilters.semester = $('#filterSemester').val();
        savedFilters.startDate = $('#filterStartDate').val();
        savedFilters.endDate = $('#filterEndDate').val();
        
        // Apply filters without submitting the form
        applyFiltersAjax();
        
        // Update URL without page reload
        updateUrl();
        
        // Return false to prevent any default actions
        return false;
    });
    
    // Handle clear filters button
    $('#clearDates').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Clear values
        $('#filterSchoolYear').val('');
        $('#filterSemester').val('');
        $('#filterStartDate').val('');
        $('#filterEndDate').val('');
        
        // Update saved filters
        savedFilters.schoolYearId = '';
        savedFilters.semester = '';
        savedFilters.startDate = '';
        savedFilters.endDate = '';
        
        // Apply filters
        applyFiltersAjax();
        
        // Update URL
        updateUrl();
        
        return false;
    });
    
    // Disable the normal form submission completely
    $('#transparencyFilterForm').on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    });
    
    function updateUrl() {
        // Build query parameters
        const params = new URLSearchParams();
        if (savedFilters.schoolYearId) params.append('school_year_id', savedFilters.schoolYearId);
        if (savedFilters.semester) params.append('semester', savedFilters.semester);
        if (savedFilters.startDate) params.append('start_date', savedFilters.startDate);
        if (savedFilters.endDate) params.append('end_date', savedFilters.endDate);
        
        // Update URL without reloading the page
        const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.pushState({ path: newUrl }, '', newUrl);
    }
    
    // AJAX filtering function
    function applyFiltersAjax() {
        // Show loading indicator
        $('#transparencyTableContainer').addClass('loading');
        
        console.log("Applying filters with values:", savedFilters);
        
        // AJAX request
        $.ajax({
            url: '../../handler/admin/getTransparency.php',
            type: 'GET',
            data: {
                action: 'get_transactions',
                school_year_id: savedFilters.schoolYearId,
                semester: savedFilters.semester,
                start_date: savedFilters.startDate,
                end_date: savedFilters.endDate
            },
            success: function(response) {
                try {
                    const data = JSON.parse(response);
                    
                    // Update cash-in table
                    updateCashInTable(data.cashIn);
                    
                    // Update cash-out table
                    updateCashOutTable(data.cashOut);
                    
                    // Update summary totals
                    $('.summary-table tbody tr:eq(0) td:eq(1)').html('₱' + data.totalCashIn.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('.summary-table tbody tr:eq(1) td:eq(1)').html('₱' + data.totalCashOut.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('.summary-table tbody tr:eq(2) td:eq(1) strong').html('₱' + data.totalFunds.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    
                    // Force restore the filter values from our saved object
                    restoreFilterValues();
                    
                    // Remove loading indicator
                    $('#transparencyTableContainer').removeClass('loading');
                } catch (e) {
                    console.error("Error parsing response:", e);
                    
                    // Force restore the filter values from our saved object
                    restoreFilterValues();
                    
                    // Remove loading indicator
                    $('#transparencyTableContainer').removeClass('loading');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                
                // Force restore the filter values from our saved object
                restoreFilterValues();
                
                // Remove loading indicator
                $('#transparencyTableContainer').removeClass('loading');
            }
        });
    }
    
    // Function to explicitly restore filter values without triggering change events
    function restoreFilterValues() {
        console.log("Restoring filter values:", savedFilters);
        
        // Use setTimeout to ensure this happens after any other DOM operations
        setTimeout(function() {
            // Temporarily disable change event handlers
            $('#filterSchoolYear, #filterSemester, #filterStartDate, #filterEndDate').off('change');
            
            // Set the values directly
            document.getElementById('filterSchoolYear').value = savedFilters.schoolYearId;
            document.getElementById('filterSemester').value = savedFilters.semester;
            document.getElementById('filterStartDate').value = savedFilters.startDate;
            document.getElementById('filterEndDate').value = savedFilters.endDate;
            
            // Reattach change event handlers
            $('#filterSchoolYear, #filterSemester, #filterStartDate, #filterEndDate').on('change', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Save the values immediately when changed
                savedFilters.schoolYearId = $('#filterSchoolYear').val();
                savedFilters.semester = $('#filterSemester').val();
                savedFilters.startDate = $('#filterStartDate').val();
                savedFilters.endDate = $('#filterEndDate').val();
                
                // Apply filters without submitting the form
                applyFiltersAjax();
                
                // Update URL without page reload
                updateUrl();
                
                // Return false to prevent any default actions
                return false;
            });
        }, 10);
    }
    
    function updateCashInTable(cashInData) {
        // Get the table element
        const tableElement = document.getElementById('cashinTable');
        const table = $('#cashinTable').DataTable();
        
        // Clear the table
        table.clear().draw();
        
        // If we have data, rebuild the table manually
        if (cashInData && Array.isArray(cashInData) && cashInData.length > 0) {
            // Get the tbody element
            const tbody = tableElement.querySelector('tbody');
            
            // Empty the tbody
            tbody.innerHTML = '';
            
            // Add each row manually
            cashInData.forEach(function(transaction) {
                try {
                    // Format date for display
                    let dateDisplay = 'N/A';
                    if (transaction.report_date) {
                        dateDisplay = formatDate(transaction.report_date);
                        if (transaction.end_date) {
                            dateDisplay += ' to ' + formatDate(transaction.end_date);
                        }
                    }
                    
                    // Format day display
                    let dayDisplay = 'N/A';
                    if (transaction.report_date) {
                        try {
                            const startDay = new Date(transaction.report_date).toLocaleDateString('en-US', { weekday: 'long' });
                            dayDisplay = startDay;
                            
                            if (transaction.end_date) {
                                const endDay = new Date(transaction.end_date).toLocaleDateString('en-US', { weekday: 'long' });
                                if (startDay != endDay) {
                                    dayDisplay = startDay + ' - ' + endDay;
                                }
                            }
                        } catch (err) {
                            console.error('Error formatting day:', err);
                        }
                    }
                    
                    // Create row HTML
                    const tr = document.createElement('tr');
                    
                    // Create date cell with data-order attribute
                    const dateCell = document.createElement('td');
                    dateCell.setAttribute('data-order', transaction.report_date || '');
                    dateCell.textContent = dateDisplay;
                    tr.appendChild(dateCell);
                    
                    // Add day cell
                    const dayCell = document.createElement('td');
                    dayCell.textContent = dayDisplay;
                    tr.appendChild(dayCell);
                    
                    // Add detail cell
                    const detailCell = document.createElement('td');
                    detailCell.textContent = transaction.expense_detail || 'N/A';
                    tr.appendChild(detailCell);
                    
                    // Add category cell
                    const categoryCell = document.createElement('td');
                    categoryCell.textContent = transaction.expense_category || 'N/A';
                    tr.appendChild(categoryCell);
                    
                    // Add amount cell
                    const amountCell = document.createElement('td');
                    amountCell.textContent = '₱' + (parseFloat(transaction.amount || 0).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    tr.appendChild(amountCell);
                    
                    // Add action cell
                    const actionCell = document.createElement('td');
                    actionCell.innerHTML = `
                        <button class="admin-btn admin-btn-edit" onclick="openTransactionModal('addEditCashInModal', ${transaction.report_id || 0}, 'edit', 'Cash In')"><i class="bi bi-pencil"></i></button> 
                        <button class="admin-btn admin-btn-delete" onclick="openTransactionModal('deleteCashInModal', ${transaction.report_id || 0}, 'delete', 'Cash In')"><i class="bi bi-trash"></i></button>
                    `;
                    tr.appendChild(actionCell);
                    
                    // Add the row to the tbody
                    tbody.appendChild(tr);
                    
                } catch (err) {
                    console.error('Error adding row to cashinTable:', err, transaction);
                }
            });
            
            // Reinitialize the DataTable
            table.rows.add($(tbody).find('tr')).draw();
        }
    }
    
    function updateCashOutTable(cashOutData) {
        // Get the table element
        const tableElement = document.getElementById('cashoutTable');
        const table = $('#cashoutTable').DataTable();
        
        // Clear the table
        table.clear().draw();
        
        // If we have data, rebuild the table manually
        if (cashOutData && Array.isArray(cashOutData) && cashOutData.length > 0) {
            // Get the tbody element
            const tbody = tableElement.querySelector('tbody');
            
            // Empty the tbody
            tbody.innerHTML = '';
            
            // Add each row manually
            cashOutData.forEach(function(transaction) {
                try {
                    // Format date for display
                    let dateDisplay = 'N/A';
                    if (transaction.report_date) {
                        dateDisplay = formatDate(transaction.report_date);
                        if (transaction.end_date) {
                            dateDisplay += ' to ' + formatDate(transaction.end_date);
                        }
                    }
                    
                    // Format day display
                    let dayDisplay = 'N/A';
                    if (transaction.report_date) {
                        try {
                            const startDay = new Date(transaction.report_date).toLocaleDateString('en-US', { weekday: 'long' });
                            dayDisplay = startDay;
                            
                            if (transaction.end_date) {
                                const endDay = new Date(transaction.end_date).toLocaleDateString('en-US', { weekday: 'long' });
                                if (startDay != endDay) {
                                    dayDisplay = startDay + ' - ' + endDay;
                                }
                            }
                        } catch (err) {
                            console.error('Error formatting day:', err);
                        }
                    }
                    
                    // Create row HTML
                    const tr = document.createElement('tr');
                    
                    // Create date cell with data-order attribute
                    const dateCell = document.createElement('td');
                    dateCell.setAttribute('data-order', transaction.report_date || '');
                    dateCell.textContent = dateDisplay;
                    tr.appendChild(dateCell);
                    
                    // Add day cell
                    const dayCell = document.createElement('td');
                    dayCell.textContent = dayDisplay;
                    tr.appendChild(dayCell);
                    
                    // Add detail cell
                    const detailCell = document.createElement('td');
                    detailCell.textContent = transaction.expense_detail || 'N/A';
                    tr.appendChild(detailCell);
                    
                    // Add category cell
                    const categoryCell = document.createElement('td');
                    categoryCell.textContent = transaction.expense_category || 'N/A';
                    tr.appendChild(categoryCell);
                    
                    // Add amount cell
                    const amountCell = document.createElement('td');
                    amountCell.textContent = '₱' + (parseFloat(transaction.amount || 0).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    tr.appendChild(amountCell);
                    
                    // Add action cell
                    const actionCell = document.createElement('td');
                    actionCell.innerHTML = `
                        <button class="admin-btn admin-btn-edit" onclick="openTransactionModal('addEditCashOutModal', ${transaction.report_id || 0}, 'edit', 'Cash Out')"><i class="bi bi-pencil"></i></button> 
                        <button class="admin-btn admin-btn-delete" onclick="openTransactionModal('deleteCashOutModal', ${transaction.report_id || 0}, 'delete', 'Cash Out')"><i class="bi bi-trash"></i></button>
                    `;
                    tr.appendChild(actionCell);
                    
                    // Add the row to the tbody
                    tbody.appendChild(tr);
                    
                } catch (err) {
                    console.error('Error adding row to cashoutTable:', err, transaction);
                }
            });
            
            // Reinitialize the DataTable
            table.rows.add($(tbody).find('tr')).draw();
        }
    }
    
    function formatDate(dateString) {
        try {
            if (!dateString) return 'N/A';
            
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return 'Invalid Date';
            
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return months[date.getMonth()] + ' ' + date.getDate() + ', ' + date.getFullYear();
        } catch (err) {
            console.error('Error in formatDate:', err, dateString);
            return 'N/A';
        }
    }
}); 