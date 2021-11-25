<div class="container errors">
    <?php
    foreach (\Core\Session::getAndForget('errors', []) as $error): ?>
        <p class="alert alert-danger"><?php echo $error; ?></p>
    <?php endforeach; ?>

    <?php
    foreach (\Core\Session::getAndForget('success', []) as $success): ?>
        <p class="alert alert-success"><?php echo $success; ?></p>
    <?php endforeach; ?>
</div>