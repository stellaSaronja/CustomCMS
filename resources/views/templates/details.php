<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Details</title>
    <link rel="stylesheet" href="/resources/css/style.css">
    <link rel="stylesheet" href="/resources/css/details.css">
</head>
<body>
    
<main class="details__main">
    <div class="img__container">
        <p class="details__title">Lorem ipsum dolor sit amet</p>
        <img src="../../imgs/magnolia.jpg" alt="Magnolia tote bag">
    </div>

    <div class="detail__features">
        <p class="detail__title">Price:</p>
        <span class="prod__price">20€</span>
        
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
    <!-- @todo: set link href -->
    <a href="" class="detail__btn">Add to cart</a>

</main>

</body>
</html>