// Глобальная функция добавления в корзину (для страниц без своего скрипта)
if (typeof AddToCart === 'undefined') {
    window.AddToCart = async function(button) {
        const fd = new FormData();
        fd.append("product_id", button.dataset.productId);
        button.disabled = true;
        try {
            const res  = await fetch("/src/actions/product/add_to_cart.php", { method: "POST", body: fd });
            const data = await res.json();
            if (data.redirect) { window.location.href = data.redirect; return; }
            if (data.success) {
                const badge = document.querySelector('.header__cart-badge');
                if (badge) {
                    badge.textContent = parseInt(badge.textContent || '0') + 1;
                } else {
                    const cartIcon = document.querySelector('a[href="/cart"].header__icon');
                    if (cartIcon) cartIcon.insertAdjacentHTML('beforeend', '<span class="header__cart-badge">1</span>');
                }
            }
        } catch(e) { console.error(e); }
        button.disabled = false;
    };
}
