<div class="row">
    <div class="col">
        <p>
            <strong>Username</strong>
        </p>
        <div>
            <?php
            echo $user->username; ?>
        </div>
    </div>

    <div class="col">
        <p>
            <strong>eMail</strong>
        </p>
        <div>
            <?php
            echo $user->email; ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <p>
            <strong>Name</strong>
        </p>
        <div><?php
            echo $user->name; ?></div>
    </div>

    <div class="col">
        <p>
            <strong>Surname</strong>
        </p>
        <div><?php
            echo $user->surname; ?></div>
    </div>
</div>

<div class="buttons mt-1">
    <a href="<?php
    echo BASE_URL . '/users'; ?>" class="btn btn-danger">zurück</a>
</div>
