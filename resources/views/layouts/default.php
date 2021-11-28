<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Totes:cool Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/prods.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/details.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/cart.css">
</head>
<body>
  <?php require_once __DIR__ . '/../partials/nav.php'; ?>

  <?php require_once __DIR__ . '/../partials/flashMessagesAndErrors.php'; ?>

  <?php echo $templatePath; ?>

  <?php require_once __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>