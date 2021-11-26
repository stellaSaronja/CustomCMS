<div class="container errors">
    <?php
    foreach (\Core\Session::getAndForget('errors', []) as $error): ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>

    <?php
    foreach (\Core\Session::getAndForget('success', []) as $success): ?>
        <p><?php echo $success; ?></p>
    <?php endforeach; ?>
</div>