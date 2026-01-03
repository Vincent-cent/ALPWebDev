/**
 * Game Detail JavaScript
 * Handles price calculations, form validation, and promo code verification
 */

class GameDetail {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupFormValidation();
    }

    setupEventListeners() {
        // Price calculation
        document.querySelectorAll('input[name="item_id"], input[name="metode_pembayaran_id"]').forEach(radio => {
            radio.addEventListener('change', () => this.calculateTotal());
        });

        const checkPromoBtn = document.getElementById('checkPromoBtn');
        if (checkPromoBtn) {
            checkPromoBtn.addEventListener('click', () => this.verifyPromoCode());
        }

        // Form submission
        const purchaseForm = document.getElementById('purchaseForm');
        if (purchaseForm) {
            purchaseForm.addEventListener('submit', (e) => this.handleFormSubmission(e));
        }
    }

    calculateTotal() {
        const itemRadio = document.querySelector('input[name="item_id"]:checked');
        
        if (itemRadio) {
            const itemPrice = parseFloat(itemRadio.dataset.price) || 0;
            
            // Update total for each payment method
            document.querySelectorAll('input[name="metode_pembayaran_id"]').forEach(paymentRadio => {
                const paymentFee = parseFloat(paymentRadio.dataset.fee) || 0;
                const total = itemPrice + paymentFee;
                
                // Find the total-price span in the same payment method container
                const paymentLabel = paymentRadio.nextElementSibling; // label element
                if (paymentLabel) {
                    const totalPriceSpan = paymentLabel.querySelector('.total-price');
                    if (totalPriceSpan) {
                        totalPriceSpan.textContent = 'Rp. ' + total.toLocaleString('id-ID');
                    }
                }
            });
        }
    }

    verifyPromoCode() {
        const promoCode = document.getElementById('promoCodeInput').value;
        const messageDiv = document.getElementById('promoMessage');
        const checkBtn = document.getElementById('checkPromoBtn');
        
        if (!promoCode) {
            this.showPromoMessage('Masukkan kode promo terlebih dahulu', 'danger');
            return;
        }

        // Disable button and show loading
        checkBtn.disabled = true;
        checkBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Checking...';
        
        // CSRF token
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                     document.querySelector('input[name="_token"]')?.value;

        fetch('/promo/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ code: promoCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                const message = `Kode Promo Valid! Selamat anda mendapatkan potongan sebesar ${data.discount}% (Maksimal Rp.${data.max_discount.toLocaleString('id-ID')}) dalam pembelian ini!`;
                this.showPromoMessage(message, 'success');
            } else {
                this.showPromoMessage(data.message || 'Kode promo tidak valid atau sudah kadaluarsa', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.showPromoMessage('Terjadi kesalahan saat verifikasi kode promo', 'danger');
        })
        .finally(() => {
            // Re-enable button
            checkBtn.disabled = false;
            checkBtn.innerHTML = 'Cek Kode →';
        });
    }

    showPromoMessage(message, type) {
        const messageDiv = document.getElementById('promoMessage');
        if (messageDiv) {
            messageDiv.innerHTML = `<small class="text-${type}">${message}</small>`;
        }
    }

    setupFormValidation() {
        const form = document.getElementById('purchaseForm');
        if (!form) return;

        // Add Bootstrap validation classes
        form.addEventListener('submit', (e) => {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }

    handleFormSubmission(e) {
        const form = e.target;
        console.log('Form submission started...');
        
        // Final validation
        const requiredFields = ['user_id', 'item_id', 'metode_pembayaran_id', 'phone'];
        let isValid = true;

        requiredFields.forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (!field || !field.value.trim()) {
                isValid = false;
                console.log(`Missing field: ${fieldName}`);
                if (field) {
                    field.classList.add('is-invalid');
                }
            } else {
                console.log(`Field ${fieldName}: ${field.value}`);
            }
        });

        if (!isValid) {
            e.preventDefault();
            console.log('Form validation failed');
            alert('Mohon lengkapi semua field yang diperlukan');
            return false;
        }

        console.log('Form validation passed, submitting via AJAX...');
        
        // Prevent default form submission
        e.preventDefault();

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
        }

        // Get form data
        const formData = new FormData(form);
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // First, submit to create transaction
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    console.error('Transaction creation error:', data);
                    throw new Error(data.message || data.errors ? JSON.stringify(data.errors) : 'Transaction creation failed');
                });
            }
            return response.json();
        })
        .then(transaksiData => {
            console.log('Transaction created:', transaksiData);
            
            // Get the selected item database ID
            const selectedItemId = formData.get('item_id');
            
            // Now send to APIGames
            return fetch('/game/send-to-apigames', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    transaksi_id: transaksiData.transaksi_id || transaksiData.id,
                    user_id: formData.get('user_id'),
                    server_id: formData.get('server_id'),
                    item_db_id: selectedItemId, // Database ID to fetch the product code
                })
            });
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    console.error('APIGames request error:', data);
                    throw new Error(data.message || data.errors ? JSON.stringify(data.errors) : 'APIGames request failed');
                });
            }
            return response.json();
        })
        .then(apiResult => {
            console.log('APIGames response:', apiResult);
            
            // Redirect to transaction success page or display result
            if (apiResult.success) {
                window.location.href = `/transaksi/${apiResult.transaksi_id}/success`;
            } else {
                alert('Terjadi kesalahan saat mengirim ke APIGames: ' + apiResult.message);
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '🛒 <strong>Beli Sekarang</strong>';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '🛒 <strong>Beli Sekarang</strong>';
            }
        });

        return false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    new GameDetail();
});