import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Global application scripts
document.addEventListener('DOMContentLoaded', function() {
    // Global loading indicator
    const showLoading = () => {
        document.body.style.cursor = 'wait';
    };
    
    const hideLoading = () => {
        document.body.style.cursor = 'default';
    };
    
    // Attach to forms and links if needed
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', showLoading);
    });
    
    // Global error handling
    window.addEventListener('error', function(e) {
        console.error('Global error:', e.error);
        hideLoading();
    });
    
    // CSRF token setup for AJAX requests
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        window.csrfToken = token.getAttribute('content');
    }
});
