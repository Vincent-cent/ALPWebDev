/**
 * Promo Code Form Handler
 * Manages discount field visibility based on selected discount type
 */
document.addEventListener('DOMContentLoaded', function() {
    const discountTypeSelect = document.getElementById('discount_type');
    const discountAmountField = document.getElementById('discount_amount');
    const discountPercentField = document.getElementById('discount_percent');
    
    // Exit if elements are not found (not on promo code form page)
    if (!discountTypeSelect || !discountAmountField || !discountPercentField) {
        return;
    }
    
    // Find the column containers (col-md-6)
    const discountAmountColumn = discountAmountField.closest('.col-md-6');
    const discountPercentColumn = discountPercentField.closest('.col-md-6');
    
    function toggleDiscountFields() {
        const selectedType = discountTypeSelect.value;
        
        // Initially hide both fields and remove required attributes
        discountAmountColumn.style.display = 'none';
        discountPercentColumn.style.display = 'none';
        discountAmountField.removeAttribute('required');
        discountPercentField.removeAttribute('required');
        
        if (selectedType === 'amount') {
            // Show only amount field
            discountAmountColumn.style.display = 'block';
            discountAmountField.setAttribute('required', 'required');
            discountPercentField.removeAttribute('required');
            discountPercentField.value = ''; // Clear the hidden field
            
            // Remove any validation errors from percent field
            discountPercentField.classList.remove('is-invalid');
            const percentFeedback = discountPercentField.parentElement.querySelector('.invalid-feedback');
            if (percentFeedback) percentFeedback.style.display = 'none';
            
        } else if (selectedType === 'percent') {
            // Show only percent field
            discountPercentColumn.style.display = 'block';
            discountPercentField.setAttribute('required', 'required');
            discountAmountField.removeAttribute('required');
            discountAmountField.value = ''; // Clear the hidden field
            
            // Remove any validation errors from amount field
            discountAmountField.classList.remove('is-invalid');
            const amountFeedback = discountAmountField.parentElement.querySelector('.invalid-feedback');
            if (amountFeedback) amountFeedback.style.display = 'none';
            
        } else {
            // Hide both fields when no type selected
            // Clear values for add form, but preserve for edit form
            const isEditForm = document.querySelector('input[name="_method"][value="PUT"]');
            if (!isEditForm) {
                discountAmountField.value = '';
                discountPercentField.value = '';
            }
        }
    }
    
    // Add event listener for discount type changes
    discountTypeSelect.addEventListener('change', toggleDiscountFields);
    
    // Initialize field visibility on page load
    toggleDiscountFields();
});