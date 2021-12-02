<main>
    <h2>Your cart</h2>

    <table class="cart">
        <thead>
            <th>Name</th>
            <th>Amount</th>
            <th>Price</th>
            <th>Actions</th>
            <th>Sum</th>
        </thead>

        <?php foreach ($products as $product): ?>
        <tr>
            <td>
                <?php echo $product->name; ?>
            </td>
            <td>
                <?php echo $product->count; ?>
            </td>
            <td>
                <?php echo $product->price; ?> 
            </td>
            <td>
                <a href="<?php
                echo BASE_URL . "/products/$product->id/add-to-cart"; ?>" class="btn-edit">+</a>
                <a href="<?php
                echo BASE_URL . "/products/$product->id/remove-from-cart"; ?>" class="btn-edit">-</a>
                <a href="<?php
                echo BASE_URL . "/products/$product->id/remove-all-from-cart"; ?>" class="delete-btn">Remove from cart</a>
            </td>
            <td>
                <?php echo $product->price * $product->count; ?>.00 €
            </td>
        </tr>
        <?php $total = 0; ?>
        <?php $total += $product->price * $product->count; ?>
        <?php endforeach; ?>

        <tr>
            <td colspan="4">Total:</td>
            <td><?php echo $total; ?>.00 €</td>
        </tr>
    </table>

    <?php if (\App\Models\User::isLoggedIn()): ?>
        <a href="<?php echo BASE_URL; ?>/checkout" class="checkout-btn">Checkout</a>
    <?php endif; ?>
</main>