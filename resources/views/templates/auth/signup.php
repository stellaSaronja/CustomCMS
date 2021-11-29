<div class="col-4">
    <form action="<?php echo BASE_URL; ?>/sign-up/do" method="post" class="register-form">

        <div class="input">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="input-field">
        </div>

        <div class="input">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="input-field">
        </div>

        <div class="input">
            <label for="surname">Surname:</label>
            <input type="text" name="surname" id="surname" class="input-field">
        </div>
        
        <div class="input">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" class="input-field">
        </div>

        <div class="input">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="input-field">
        </div>

        <div class="input">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="input-field">
        </div>

        <div class="input">
            <label for="password_repeat">Repeat password:</label>
            <input type="password" name="password_repeat" id="password_repeat" class="input-field">
        </div>

        <button type="submit" class="confirm-btn">Register</button>
        <a href="<?php echo BASE_URL; ?>/login" class="link-btn">Login</a>
    </form>
</div>
