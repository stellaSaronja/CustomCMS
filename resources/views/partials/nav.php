<header>
    <nav>
        <h1>Totes : cool</h1>
        
        <button class="nav__menu">
            <span class="sr-only">Menu</span> 
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 124 124" fill="#fff">
                <path d="M112 6H12C5.4 6 0 11.4 0 18s5.4 12 12 12h100c6.6 0 12-5.4 12-12s-5.4-12-12-12zM112 50H12C5.4 50 0 55.4 0 62s5.4 12 12 12h100c6.6 0 12-5.4 12-12s-5.4-12-12-12zM112 94H12c-6.6 0-12 5.4-12 12s5.4 12 12 12h100c6.6 0 12-5.4 12-12s-5.4-12-12-12z"/>
            </svg>
        </button>

        <ul class="nav__ul navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/products">Products</a>
            </li>     
            <li>
                <a href="<?php echo BASE_URL; ?>/cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="29.29" height="30" viewBox="0 0 29.29 40">
                        <path id="bag" d="M97.816,34.55,95.684,11.137A1.248,1.248,0,0,0,94.439,10h-3.75V7.5A7.455,7.455,0,0,0,88.5,2.192,7.506,7.506,0,0,0,75.689,7.5V10h-3.75a1.248,1.248,0,0,0-1.245,1.137l-2.128,23.41A5,5,0,0,0,73.546,40H92.834a5,5,0,0,0,4.982-5.45ZM88.189,10h-10V7.5a5,5,0,1,1,10,0Z" transform="translate(-68.546)" fill="#fff"/>
                    </svg>
                    <?php if(App\Models\User::isLoggedIn()): ?>
                        <small>(<?php echo \App\Services\CartService::getCount(); ?>)</small>
                    <?php endif; ?>
                </a>
            </li>
            <li>
                <?php if(App\Models\User::isLoggedIn()): ?>
                    <a href="<?php echo BASE_URL; ?>/logout">Log out</a>
                <?php else : ?>
                    <a href="<?php echo BASE_URL; ?>/login">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30" viewBox="0 0 45.532 45.532" xml:space="preserve">
                            <path d="M22.766.001C10.194.001 0 10.193 0 22.766s10.193 22.765 22.766 22.765c12.574 0 22.766-10.192 22.766-22.765S35.34.001 22.766.001zm0 6.807a7.53 7.53 0 1 1 .001 15.06 7.53 7.53 0 0 1-.001-15.06zm-.005 32.771a16.708 16.708 0 0 1-10.88-4.012 3.209 3.209 0 0 1-1.126-2.439c0-4.217 3.413-7.592 7.631-7.592h8.762c4.219 0 7.619 3.375 7.619 7.592a3.2 3.2 0 0 1-1.125 2.438 16.702 16.702 0 0 1-10.881 4.013z" fill="#fff"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
</header>