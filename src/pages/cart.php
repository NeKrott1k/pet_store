<?php
echo "cart"
?>
<img src="./public/assets/images/asd.jpg" alt="img">
<script>
    const formData = new FormData();
    formData.append("a", "asd");
    fetch('/src/actions/create/create_product.php', {
        method: 'POST',
        body: formData
    });
</script>