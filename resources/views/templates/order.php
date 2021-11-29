<main class="order__main">
    <h2>Your order</h2>

    <div class="order__background">
        <div>
            <?php foreach ($orderedProducts as $orderedProduct): ?>
            <div class="order__container">
                <img src="<?php echo IMG_FOLDER_URL; echo $orderedProduct->images ?>" alt="<?php echo $orderedProduct->images ?>" class="order__img">
                <div class="order__details">
                    <p class="order__title">Lorem ipsum dolor sit amet</p>
                    <span class="order__price"><?php echo $orderedProduct->price; ?></span>
                </div>    
            </div>
            <?php endforeach; ?>
        </div>
        <div class="order__address">
            <h3>Delivery address:</h3>
            <div class="address__details">
                <p>Max Mustermann</p>
                <p>Musterstraße 10, 1010 Wien</p>
                <p>Österreich</p>
            </div>
        </div>
        
        <div class="sum">
            <p class="sum__title">Total:</p>
            <span class="sum__price">68€</span>
        </div>

        <a href="" class="confirmation-btn">Confirm payment</a>
    </div>
</main>