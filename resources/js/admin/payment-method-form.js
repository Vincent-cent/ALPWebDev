/**
 * Payment Method Form Handler
 * Manages logo preview functionality for both uploaded and existing logos
 */
document.addEventListener('DOMContentLoaded', function() {
    const logoInput = document.getElementById('logo');
    const existingLogoSelect = document.getElementById('existing_logo');
    const previewDiv = document.getElementById('logo-preview');
    const previewImg = document.getElementById('preview-img');
    
    // Exit if elements are not found (not on payment method form page)
    if (!logoInput || !previewDiv || !previewImg) {
        return;
    }
    
    // Preview uploaded logo
    logoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Check file size (2MB limit)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                logoInput.value = '';
                previewDiv.style.display = 'none';
                return;
            }
            
            // Check file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file');
                logoInput.value = '';
                previewDiv.style.display = 'none';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewDiv.style.display = 'block';
            };
            reader.readAsDataURL(file);
            
            // Clear existing logo selection when uploading new file
            if (existingLogoSelect) {
                existingLogoSelect.value = '';
            }
        } else {
            previewDiv.style.display = 'none';
        }
    });
    
    // Preview existing logo
    if (existingLogoSelect) {
        existingLogoSelect.addEventListener('change', function(e) {
            if (e.target.value) {
                previewImg.src = '/storage/payment-methods/' + e.target.value;
                previewDiv.style.display = 'block';
                // Clear file input when selecting existing logo
                logoInput.value = '';
            } else {
                previewDiv.style.display = 'none';
            }
        });
    }
});