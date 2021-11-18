<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping cart</title>
    <link rel="stylesheet" href="../../css/cart.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<main class="cart__main">
    <h2>Your shopping cart</h2>

    <div class="cart__background">
        <div class="cart__container">
            <img src="../../imgs/librarian.jpg" alt="'Librarian' tote bag" class="cart__img">
            <div class="prod-details">
                <p class="cart__title">Lorem ipsum dolor sit amet</p>
                <p class="cart__description">Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
            </div>
            
            <div class="divider">
                <span class="cart__price">20€</span>
                <!-- set link href -->
                <a href="" class="delete-btn">Delete</a>
            </div>
        </div>

        <div class="cart__container">
            <img src="../../imgs/black.jpg" alt="Black tote bag" class="cart__img">
            <div class="prod-details">
                <p class="cart__title">Lorem ipsum dolor sit amet</p>
                <p class="cart__description">Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
            </div>

            <div class="divider">
                <span class="cart__price">23€</span>
                <!-- set link href -->
                <a href="" class="delete-btn">Delete</a>
            </div>
        </div>

        <div class="cart__container">
            <img src="../../imgs/pride.jpg" alt="Pride tote bag" class="cart__img">
            <div class="prod-details">
                <p class="cart__title">Lorem ipsum dolor sit amet</p>
                <p class="cart__description">Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
            </div>

            <div class="divider">
                <span class="cart__price">25€</span>
                <!-- set link href -->
                <a href="" class="delete-btn">Delete</a>
            </div>
        </div>
        <div class="sum">
            <p class="sum__title">Total:</p>
            <span class="sum__price">68€</span>
        </div>
    </div>
    <a href="" class="checkout-btn">Proceed to checkout</a>
</main>
</body>
</html>