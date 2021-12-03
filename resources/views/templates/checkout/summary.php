<main class="cart__main">
    <h2>Order summary</h2>
    <?php $total = 0; ?>    
    <div class="cart__background">
        <?php foreach ($cartContent as $product): ?>
            <tr>
                <td>
                    <a href="<?php echo BASE_URL; ?>/products/<?php echo $product->id; ?>/show"><?php echo $product->name; ?></a>
                </td>
                <td>
                    <?php echo $product->count; ?>
                </td>
                <td> <?php echo $product->price * $product->count; ?> €
                </td> 
            </tr>
            <?php $total += $product->price * $product->count; ?>

            <!-- <div class="cart__container">
                <img src="../../imgs/librarian.jpg" alt="'Librarian' tote bag" class="cart__img">
                <div class="prod-details">
                    <p class="cart__title">Lorem ipsum dolor sit amet</p>
                    <p class="cart__description">Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                </div>
                
                <div class="divider">
                    <span class="cart__price">20€</span>
                    <a href="" class="delete-btn">Delete</a>
                </div>
            </div> -->
        <?php endforeach; ?>

        <!-- <div class="sum">
            <p class="sum__title">Total:</p>
            <span class="sum__price">68€</span>
        </div> -->
    </div>

    <?php if (App\Models\User::isLoggedIn()): ?>
        <a href="<?php echo BASE_URL; ?>/checkout/saveOrder" class="checkout-btn">Confirm payment</a>
    <?php endif; ?>
</main>