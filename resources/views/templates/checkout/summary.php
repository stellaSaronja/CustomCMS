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
        <?php endforeach; ?>
    </div>

    <?php if (App\Models\User::isLoggedIn()): ?>
        <a href="<?php echo BASE_URL; ?>/checkout/saveOrder" class="checkout-btn">Confirm payment</a>
    <?php endif; ?>
</main>