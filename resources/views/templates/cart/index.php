<main>
    <h2>Your cart</h2>

    <table class="cart">
        <thead>
            <th>Name</th>
            <th>Units</th>
            <th>Actions</th>
        </thead>

        <?php foreach ($products as $product): ?>
        <tr>
            <td>
                <a href="<?php echo BASE_URL; ?>/products/<?php echo $product->id; ?>/show"><?php echo $product->name; ?></a>
            </td>
            <td>
                <?php echo $product->count; ?>
            </td>
            <td>
                <a href="<?php
                echo BASE_URL . "/products/$product->id/add-to-cart"; ?>" class="btn-edit">+</a>
                <a href="<?php
                echo BASE_URL . "/products/$product->id/remove-from-cart"; ?>" class="btn-edit">-</a>
                <a href="<?php
                echo BASE_URL . "/products/$product->id/remove-all-from-cart"; ?>" class="delete-btn">Remove from cart</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php if (\App\Models\User::isLoggedIn()): ?>
        <a href="<?php echo BASE_URL; ?>/checkout/summary" class="checkout-btn">Checkout</a>
    <?php endif; ?>
</main>