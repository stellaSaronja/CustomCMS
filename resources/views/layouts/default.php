<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Totes:cool Shop</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/prods.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/details.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/cart.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/order.css">
</head>
<body>

    <?php require_once __DIR__ . '/../partials/nav.php'; ?>

    <?php require_once __DIR__ . '/../partials/flashMessagesAndErrors.php'; ?>

    <?php require_once $templatePath; ?>

    <?php require_once __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>