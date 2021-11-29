<main>
    <h2>Products</h2>
    <div class="prods">
        <?php foreach ($products as $product): ?>
        <div class="prod__background">
            <img src="<?php echo IMG_FOLDER_URL; echo $product->images ?>" alt="<?php echo $product->images ?>" class="prod__img">
            <p class="prod__description">Lorem ipsum dolor sit amet</p>
            <div class="prod__divider">
                <span class="prod__price"><?php echo $product->price; ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 471.701 471.701" xml:space="preserve" fill="#FFF">
                    <path d="M433.601 67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7 13.6-92.4 38.3l-12.9 12.9-13.1-13.1c-24.7-24.7-57.6-38.4-92.5-38.4-34.8 0-67.6 13.6-92.2 38.2-24.7 24.7-38.3 57.5-38.2 92.4 0 34.9 13.7 67.6 38.4 92.3l187.8 187.8c2.6 2.6 6.1 4 9.5 4 3.4 0 6.9-1.3 9.5-3.9l188.2-187.5c24.7-24.7 38.3-57.5 38.3-92.4.1-34.9-13.4-67.7-38.1-92.4zm-19.2 165.7-178.7 178-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3s10.7-53.7 30.3-73.2c19.5-19.5 45.5-30.3 73.1-30.3 27.7 0 53.8 10.8 73.4 30.4l22.6 22.6c5.3 5.3 13.8 5.3 19.1 0l22.4-22.4c19.6-19.6 45.7-30.4 73.3-30.4 27.6 0 53.6 10.8 73.2 30.3 19.6 19.6 30.3 45.6 30.3 73.3.1 27.7-10.7 53.7-30.3 73.3z"/>
                </svg>
            </div>
            <a href="<?php echo BASE_URL; ?>/products/<?php echo $product->id; ?>/show" class="prod__btn">View product</a>
        </div>
        <?php endforeach; ?>
    </div>
</main>