// Toast notification system
function showToast(message, type = 'info', duration = 3000) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type}`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideInRight 0.3s ease;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    `;
    
    toast.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" style="
                background: none; border: none; font-size: 18px; cursor: pointer; color: inherit; margin-left: 10px;
            ">×</button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 300);
        }
    }, duration);
}

// Loading state for buttons
function showLoading(button, text = 'Loading...') {
    if (button.classList.contains('loading')) return;
    
    const originalText = button.innerHTML;
    const originalDisabled = button.disabled;
    
    button.innerHTML = `<span class="spinner"></span> ${text}`;
    button.disabled = true;
    button.classList.add('loading');
    
    return {
        stop: () => {
            button.innerHTML = originalText;
            button.disabled = originalDisabled;
            button.classList.remove('loading');
        }
    };
}