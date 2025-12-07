// Navigation enhancement scripts
document.addEventListener('DOMContentLoaded', function() {
    // Add active class based on current URL
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-icon');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && (currentPath === href || (href !== '/' && currentPath.startsWith(href)))) {
            link.classList.add('active');
        }
    });
    
    // Enhanced search functionality
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.boxShadow = '0 0 0 0.2rem rgba(255, 226, 146, 0.25)';
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.boxShadow = 'none';
        });
        
        // Search functionality (you can expand this)
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const searchTerm = this.value.trim();
                if (searchTerm) {
                    // Implement your search logic here
                    console.log('Searching for:', searchTerm);
                }
            }
        });
    }
    
    // Search button click handler
    const searchBtn = document.querySelector('.search-btn');
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            const searchInput = document.querySelector('.search-input');
            const searchTerm = searchInput.value.trim();
            if (searchTerm) {
                // Implement your search logic here
                console.log('Searching for:', searchTerm);
            }
        });
    }
    
    // Smooth scrolling for anchor links (if any)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Tooltip enhancement for mobile devices
    if (window.innerWidth <= 768) {
        const navIconContainers = document.querySelectorAll('.nav-icon-container');
        navIconContainers.forEach(container => {
            const tooltip = container.querySelector('.nav-tooltip');
            if (tooltip) {
                tooltip.style.display = 'none';
            }
        });
    }
});