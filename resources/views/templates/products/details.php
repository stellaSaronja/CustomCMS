<main class="details__main">
    <div class="img__container">
        <p class="details__title">Lorem ipsum dolor sit amet</p>
        <img src="<?php echo IMG_FOLDER_URL; echo $product->images ?>" alt="<?php echo $product->images ?>">
    </div>

    <div class="detail__features">
        <p class="detail__title">Price:</p>
        <span class="detail__price"><?php echo $product->price; ?> €</span>
        
        <p class="detail__title">Color:</p>
        <div>
            <select name="colors">
                <option value="default" selected disabled>Please choose a color</option>
                <option value="beige">Beige</option>
                <option value="white">White</option>
                <option value="red">Red</option>
                <option value="blue">Blue</option>
            </select>
        </div>

        <p class="detail__title">Description:</p>
        <p class="detail__p">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>

    </div>
    <span></span>
    <a href="<?php echo BASE_URL; ?>/products/<?php echo $product->id; ?>/add-to-cart" class="detail__btn">Add to cart</a>

</main>