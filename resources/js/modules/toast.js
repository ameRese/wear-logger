document.addEventListener('DOMContentLoaded', () => {
    const toast = document.getElementById('js-message-toast');
    const closeButton = document.getElementById('js-close-toast');

    const hideToast = () => {
        toast.classList.add('opacity-0');
        setTimeout(() => {
            toast.remove();
        }, 300);
    };

    const timeout = setTimeout(() => {
        hideToast();
    }, 5000);

    closeButton.addEventListener('click', () => {
        clearTimeout(timeout); // タイマーをクリア
        hideToast();
    });
});
