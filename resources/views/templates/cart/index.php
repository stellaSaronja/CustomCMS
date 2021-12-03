<main>
    <h2>Your cart</h2>

    <?php $total = 0; ?>
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
        <?php $total += $product->price * $product->count; ?>
        <?php endforeach; ?>

        <tr>
            <td colspan="4" class="border">Total:</td>
            <td class="border"><?php echo $total; ?>.00 €</td>
        </tr>
    </table>

    <form action="<?php echo BASE_URL; ?>/validateOrder" method="post" class="cart-form">
        <div class="address-form">
            <input type="text" name="address" placeholder="Street name" class="checkout-input" id="address">
            <input type="text" name="address-nr" placeholder="House number" class="checkout-input" id="address-nr">
            <input type="text" name="city" placeholder="City" class="checkout-input" id="city">
            <input type="text" name="postal-code" placeholder="Postal code" class="checkout-input" id="postal-code">
            <input type="text" name="state" placeholder="State" class="checkout-input" id="state">
        </div>
        
        <div class="payment-form">
            <select name="card_type" id="card_type" class="checkout-input">
                <option value="_default" selected disabled>Choose card type</option>
                <option value="visa">Visa</option>
                <option value="diners">Diners</option>
                <option value="mastercard">Mastercard</option>
            </select>

            <input type="text" name="card_holder" placeholder="Card holder" maxLength="30" class="checkout-input">
            <input type="text" name="card_number" placeholder="Card number" id="card_number" inputmode="numeric" class="checkout-input">
            <input type="text" name="expiry_date" placeholder="Expiry date" class="checkout-input">
            <input type="text" name="cvv" placeholder="CVV" inputmode="numeric" maxLength="3" class="checkout-input">
        </div>
        <input type="hidden" name="price" value="<?php echo $total; ?>" />
        <input type="hidden" name="user_id" value ="<?php echo $userId; ?>"/>
        </div>
        
        <?php if (\App\Models\User::isLoggedIn()): ?>
            <button type="submit" class="form-btn">Checkout</button>
        <?php endif; ?>
    </form>
    
    <!-- <a href="<?php echo BASE_URL; ?>/checkout" class="checkout-btn">Checkout</a> -->
</main>