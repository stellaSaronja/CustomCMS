<form action="<?php echo BASE_URL . "/products/{$product->id}/update" ?>" method="post">
    <div class="edit__container">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Name" class="edit__input" value="<?php echo $product->name; ?>" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" class="edit__input" placeholder="Description"><?php echo $product->description; ?></textarea>

        <label for="category">Category</label>
        <input type="text" name="category" id="category" placeholder="Category" class="edit__input" value="<?php echo $product->category; ?>" required>

        <label for="price">Price</label>
        <input type="text" name="price" id="price" placeholder="Price" class="edit__input" value="<?php echo $product->price; ?>" required>

        <label for="images">Images</label>
        <input type="file" class="edit__input" id="images" name="images[]" multiple>
    </div>

    <div class="buttons">
        <button type="submit" class="btn__save">Save</button>
        <a href="<?php echo BASE_URL . '/products'; ?>" class="btn__cancel">Cancel</a>
    </div>
</form>