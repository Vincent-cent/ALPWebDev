// Beranda page JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap carousel with custom options
    const bannerCarousel = document.getElementById('bannerCarousel');
    if (bannerCarousel) {
        new bootstrap.Carousel(bannerCarousel, {
            interval: 5000,
            wrap: true,
            touch: true
        });
    }
    
    // Add click handlers for game cards
    const gameCards = document.querySelectorAll('.game-card');
    gameCards.forEach(card => {
        card.addEventListener('click', function() {
            const gameName = this.querySelector('.card-title').textContent;
            // You can implement navigation to game detail page here
            console.log('Clicked on game:', gameName);
        });
    });
    
    // Add click handlers for voucher cards
    const voucherCards = document.querySelectorAll('.voucher-card');
    voucherCards.forEach(card => {
        card.addEventListener('click', function() {
            const voucherName = this.querySelector('.card-title').textContent;
            // You can implement navigation to voucher detail page here
            console.log('Clicked on voucher:', voucherName);
        });
    });
    
    // Add click handlers for buy buttons
    const buyButtons = document.querySelectorAll('.btn-buy-item');
    buyButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent card click event
            const itemName = this.closest('.card').querySelector('.card-title').textContent;
            const price = this.closest('.card').querySelector('.price').textContent;
            
            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Loading...';
            this.disabled = true;
            
            // Simulate API call (replace with actual implementation)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
                
                // Show success message (you can use Bootstrap toast here)
                console.log('Added to cart:', itemName, price);
                
                // Optional: Show toast notification
                showToast('Item berhasil ditambahkan ke keranjang!', 'success');
            }, 1000);
        });
    });
    
    // Smooth scroll to sections
    const ctaButton = document.querySelector('.btn-cta-games');
    if (ctaButton) {
        ctaButton.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector('#games-section');
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }
    
    // Lazy loading for game icons (if needed)
    const gameImages = document.querySelectorAll('.game-card img[data-src]');
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        gameImages.forEach(img => imageObserver.observe(img));
    }
});

// Toast notification function
function showToast(message, type = 'info') {
    // Create toast element if it doesn't exist
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    const toastId = 'toast-' + Date.now();
    const toastHTML = `
        <div class="toast" id="${toastId}" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fas fa-${type === 'success' ? 'check-circle text-success' : 'info-circle text-info'} me-2"></i>
                <strong class="me-auto">TOSHOP</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 3000
    });
    
    toast.show();
    
    // Remove toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
}