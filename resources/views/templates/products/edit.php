<form action="<?php echo BASE_URL . "/products/{$product->id}/update" ?>" method="post">

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="<?php echo $product->name; ?>" required>
            </div>
        </div>
        <div class="col">
            <div class="form-group mt-1">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Description"><?php echo $product->description; ?></textarea>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" placeholder="Category" class="form-control" value="<?php echo $product->category; ?>" required>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" placeholder="Price" class="form-control" value="<?php echo $product->price; ?>" required>
            </div>
        </div>
        <div class="col">
            <label for="images">Images</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple>
        </div>
    </div>

    <div class="buttons mt-1">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?php echo BASE_URL . '/products'; ?>" class="btn btn-danger">Cancel</a>
    </div>
</form>