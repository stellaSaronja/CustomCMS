<form action="<?php echo BASE_URL; ?>/login/do" method="post">

    <div class="input">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" class="input-field">
    </div>

    <div class="input">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="input-field">
    </div>

    <div class="input">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" class="input-field">
    </div>

    <button type="submit" class="confirm-btn">Login</button>
    <a href="<?php echo BASE_URL; ?>/sign-up" class="link-btn">Register</a>
</form>
