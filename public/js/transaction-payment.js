/**
 * Transaction Payment JavaScript
 * Handles Midtrans Snap payment integration
 */

class TransactionPayment {
    constructor(snapToken, successUrl, transactionId) {
        this.snapToken = snapToken;
        this.successUrl = successUrl;
        this.transactionId = transactionId;
        console.log('TransactionPayment initialized with token:', snapToken);
        this.init();
    }

    init() {
        this.setupPayButton();
        this.loadMidtransScript();
    }

    setupPayButton() {
        const payButton = document.getElementById('pay-button');
        console.log('Pay button found:', payButton);
        if (payButton) {
            payButton.addEventListener('click', () => {
                console.log('Pay button clicked');
                this.processPayment();
            });
        }
    }

    loadMidtransScript() {
        // Check if snap script is already loaded
        if (typeof window.snap !== 'undefined') {
            console.log('Midtrans Snap already loaded');
            return;
        }

        console.log('Loading Midtrans Snap script...');
        const script = document.createElement('script');
        script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
        script.setAttribute('data-client-key', window.midtransClientKey);
        script.onload = () => {
            console.log('Midtrans Snap script loaded successfully');
        };
        script.onerror = () => {
            console.error('Failed to load Midtrans Snap script');
        };
        document.head.appendChild(script);
    }

    processPayment() {
        console.log('Processing payment with snap token:', this.snapToken);
        
        if (typeof window.snap === 'undefined') {
            console.error('Midtrans Snap not loaded');
            alert('Payment system is loading, please try again in a moment.');
            return;
        }

        console.log('Opening Midtrans Snap popup...');
        window.snap.pay(this.snapToken, {
            onSuccess: (result) => {
                console.log('Payment success:', result);
                this.handlePaymentSuccess(result);
            },
            onPending: (result) => {
                console.log('Payment pending:', result);
                this.handlePaymentPending(result);
            },
            onError: (result) => {
                this.handlePaymentError(result);
            },
            onClose: () => {
                this.handlePaymentClose();
            }
        });
    }

    handlePaymentSuccess(result) {
        console.log('Payment Success:', result);
        
        // Show success message
        this.showNotification('Payment successful! Redirecting...', 'success');
        
        // Redirect to success page after a short delay
        setTimeout(() => {
            window.location.href = this.successUrl;
        }, 1500);
    }

    handlePaymentPending(result) {
        console.log('Payment Pending:', result);
        this.showNotification('Payment is being processed. Please wait for confirmation.', 'warning');
    }

    handlePaymentError(result) {
        console.log('Payment Error:', result);
        this.showNotification('Payment failed. Please try again.', 'error');
    }

    handlePaymentClose() {
        console.log('Payment popup closed');
        this.showNotification('Payment cancelled.', 'info');
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${this.getBootstrapClass(type)} alert-dismissible fade show`;
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '300px';
        
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    getBootstrapClass(type) {
        const classMap = {
            'success': 'success',
            'error': 'danger',
            'warning': 'warning',
            'info': 'info'
        };
        return classMap[type] || 'info';
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing payment...');
    
    // Check if we're on a payment page
    const snapToken = document.querySelector('meta[name="snap-token"]')?.getAttribute('content');
    const successUrl = document.querySelector('meta[name="success-url"]')?.getAttribute('content');
    const transactionId = document.querySelector('meta[name="transaction-id"]')?.getAttribute('content');

    console.log('Payment data:', {
        snapToken: snapToken,
        successUrl: successUrl,
        transactionId: transactionId,
        clientKey: window.midtransClientKey
    });

    if (snapToken && successUrl && transactionId) {
        new TransactionPayment(snapToken, successUrl, transactionId);
    } else {
        console.error('Missing payment data', {
            snapToken: !!snapToken,
            successUrl: !!successUrl,
            transactionId: !!transactionId
        });
    }
});