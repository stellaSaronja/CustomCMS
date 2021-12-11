<main>
    <h2>
        Products
        <?php
        if (\App\Models\User::isLoggedIn()): ?>
            <a href="<?php
            echo BASE_URL; ?>/products/create" class="new-btn">New</a>
        <?php
        endif; ?>
    </h2>
    
    <div class="prods">
        <?php foreach ($products as $product): ?>
            <div class="prod__background">
                <img src="<?php echo IMG_FOLDER_URL; echo $product->images ?>" alt="<?php echo $product->images ?>" class="prod__img">
                <p class="prod__description"><?php echo $product->name; ?></p>
                <span class="prod__price"><?php echo $product->price; ?> €</span>
                <a href="<?php echo BASE_URL; ?>/products/<?php echo $product->id; ?>/show" class="prod__btn">View product</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>