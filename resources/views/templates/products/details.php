<main class="details__main">
    <div class="img__container">
        <p class="details__title"><?php echo $product->name; ?></p>
        <img src="<?php echo IMG_FOLDER_URL; echo $product->images ?>" alt="<?php echo $product->images ?>" class="details__img">
    </div>

    <div class="detail__features">
        <p class="detail__title">Price:</p>
        <span class="detail__price"><?php echo $product->price; ?> €</span>

        <p class="detail__title">Description:</p>
        <p class="detail__p"><?php echo $product->description; ?></p>

        <?php if(\Core\Middlewares\AuthMiddleware::isAdmin()): ?>
            <a href="<?php echo BASE_URL . "/products/$product->id"; ?>" class="admin__edit">Edit</a>
        <?php endif; ?>

        <?php if(\Core\Middlewares\AuthMiddleware::isAdmin()): ?>
            <a href="<?php echo BASE_URL . "/products/$product->id/delete"; ?>" class="admin__delete">Delete</a>
        <?php endif; ?>
    </div>
    <span></span>
    <a href="<?php echo BASE_URL; ?>/products/<?php echo $product->id; ?>/add-to-cart" class="detail__btn">Add to cart</a>

</main>