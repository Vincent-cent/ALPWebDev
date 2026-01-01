/**
 * Transaction History Filter and Search
 * Handles filtering and search functionality for transaction history page
 */
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('status_filter');
    const dateFromFilter = document.getElementById('date_from');
    const dateToFilter = document.getElementById('date_to');
    const filterButton = document.getElementById('filter_button');
    const searchForm = document.getElementById('filter_form');
    
    // Exit if elements are not found (not on history page)
    if (!statusFilter || !dateFromFilter || !dateToFilter || !filterButton || !searchForm) {
        return;
    }
    
    // Auto-submit form when filters change
    function submitFilter() {
        searchForm.submit();
    }
    
    // Add event listeners for auto-filtering
    statusFilter.addEventListener('change', submitFilter);
    
    // Add event listener for filter button
    filterButton.addEventListener('click', function(e) {
        e.preventDefault();
        submitFilter();
    });
    
    // Reset filters function
    function resetFilters() {
        statusFilter.value = '';
        dateFromFilter.value = '';
        dateToFilter.value = '';
        
        // Remove URL parameters and reload
        const url = new URL(window.location);
        url.search = '';
        window.location.href = url.toString();
    }
    
    // Add reset button if needed
    const resetButton = document.getElementById('reset_button');
    if (resetButton) {
        resetButton.addEventListener('click', function(e) {
            e.preventDefault();
            resetFilters();
        });
    }
    
    // Date validation
    dateFromFilter.addEventListener('change', function() {
        if (dateToFilter.value && this.value > dateToFilter.value) {
            dateToFilter.value = this.value;
        }
        dateToFilter.min = this.value;
    });
    
    dateToFilter.addEventListener('change', function() {
        if (dateFromFilter.value && this.value < dateFromFilter.value) {
            dateFromFilter.value = this.value;
        }
        dateFromFilter.max = this.value;
    });
    
    // Export functionality
    const exportButton = document.getElementById('export_button');
    if (exportButton) {
        exportButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get current filter parameters
            const params = new URLSearchParams(window.location.search);
            params.set('export', 'true');
            
            // Create download link
            const exportUrl = window.location.pathname + '?' + params.toString();
            window.open(exportUrl, '_blank');
        });
    }
});