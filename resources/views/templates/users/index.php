<h2>
    Users
</h2>

<table class="table table-striped">
    <thead>
    <th>#</th>
    <th>Username</th>
    <th>Name</th>
    <th>Surname</th>
    <th>e-Mail</th>
    <th>Created At</th>
    </thead>
    <?php
    /**
     * Alle users durchgehen und eine List ausgeben.
     */
    foreach ($users as $user): ?>

        <tr>
            <td><?php
                echo $user->id; ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>/users/<?php echo $user->id; ?>/show"><?php
                    echo $user->username; ?>
                </a>
            </td>
            <td><?php
                echo $user->name; ?></td>
            <td><?php
                echo $user->surname; ?></td>
            <td><?php
                echo $user->email; ?></td>
            <td><?php
                echo $user->created_at; ?>
            </td>
        </tr>

    <?php
    endforeach; ?>
</table>
