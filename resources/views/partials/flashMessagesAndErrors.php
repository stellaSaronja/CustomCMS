<div class="container errors">
    <?php
    /**
     * Hier lesen wir bei jedem Rendering Vorgang einer Seite die Fehler aus der Session aus. Dabei übergeben wir als
     * 2. Parameter ($default) ein leeres Array, falls keine Fehler in der Session stehen. Dann gehen wir die Fehler
     * durch und geben sie als Alert aus.
     */
    foreach (\Core\Session::getAndForget('errors', []) as $error): ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>
</div>