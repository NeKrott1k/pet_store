async function deleteFromCart(button, in_cart = false) {
        let formdata = new FormData();
        const counter = document.getElementById('in_cart_' + button.getAttribute("data-product-id"))

        formdata.append("product_id", button.getAttribute("data-product-id"));
        button.disabled = true;

        let data = null

        try {
            result = await fetch("/src/actions/product/delete-from-cart.php", {
                method: "POST",
                body: formdata,
            })
            data = await result.json();
            
            if (data.redirect) {
                window.location.href = data.redirect;
                return;
            }
            
            
            if (data.success != true) {
                // counter.textContent = oldValue;
                throw new Error(`Ошибка сервера: ${res.status}`);
            }
            
            counter.textContent = counter.textContent - 1;

        } catch (error) {
            console.log(error);
        }
        button.disabled = false;
        return data
    }