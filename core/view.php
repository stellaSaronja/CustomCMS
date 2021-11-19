<?php

namespace Core;

class View {

    public function render(
        ?string $layout
    ) {
        if ($layout === null) {
            $layout = Config::get('app.default-layout', 'default');
        }
    }
}