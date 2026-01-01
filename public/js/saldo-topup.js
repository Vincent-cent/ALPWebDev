document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('.payment-method');
    const metodePembayaranInput = document.getElementById('metode_pembayaran_id');
    
    console.log('Saldo top-up page loaded');
    console.log('Found payment methods:', paymentMethods.length);
    console.log('Method input element:', metodePembayaranInput);
    
    paymentMethods.forEach((method, index) => {
        method.addEventListener('click', function() {
            // Remove selected class from all methods
            paymentMethods.forEach(m => m.classList.remove('selected'));
            // Add selected class to clicked method
            this.classList.add('selected');
            
            // Set the payment method ID
            const methodId = this.getAttribute('data-method-id');
            console.log('Clicked payment method:', this);
            console.log('Method ID:', methodId);
            
            if (methodId && metodePembayaranInput) {
                metodePembayaranInput.value = methodId;
                console.log('Set input value to:', metodePembayaranInput.value);
            } else {
                console.error('Missing methodId or input element');
            }
        });
    });
    
    // Form submission debugging
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form being submitted');
            console.log('Payment method ID:', metodePembayaranInput ? metodePembayaranInput.value : 'not found');
            console.log('Amount:', document.querySelector('input[name="amount"]')?.value);
            console.log('Phone:', document.querySelector('input[name="phone"]')?.value);
        });
    }
});