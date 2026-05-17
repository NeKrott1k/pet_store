async function addToCart(button, in_cart = false) {
        let formdata = new FormData();
        const counter = document.getElementById('in_cart_' + button.getAttribute("data-product-id"))
        const total_amount = document.getElementById('total_amount')
        const product_sum = document.getElementById('product_sum_' + button.getAttribute("data-product-id"))
        formdata.append("product_id", button.getAttribute("data-product-id"));
        // button.disabled = true;

        try {
            result = await fetch("/src/actions/product/add-to-cart.php", {
                method: "POST",
                body: formdata,
            })
            let data = await result.json();
            
            if (data.redirect) {
                window.location.href = data.redirect;
                return;
            }
            
            
            if (data.success != true) {
                // counter.textContent = oldValue;
                throw new Error(`Ошибка сервера: ${res.status}`);
            }            

            if(in_cart){
                animateValue(product_sum, product_sum.textContent, +product_sum.textContent + data.product_price, 400);
                animateValue(total_amount, total_amount.textContent, +total_amount.textContent + data.product_price, 400);
            }
            
            
            counter.textContent = +counter.textContent + 1;

        } catch (error) {
            console.log(error);
        }
        button.disabled = false;
    }