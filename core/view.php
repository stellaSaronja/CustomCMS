<?php

namespace Core;

class View {

    public function render(
        string $template,
        array $params = [],
        ?string $layout = null,
        bool $useCoreTemplates = false
    ) {
        if ($layout === null) {
            $layout = Config::get('app.default-layout', 'default');
        }

        if (!empty($params)) {
            extract($params);
        }

        $viewBasePath = __DIR__ . '/../resources/views';
        $layoutsBasePath = "{$viewBasePath}/layouts";
        $templatesBasePath = "{$viewBasePath}/templates";

        if ($useCoreTemplates === true) {
            $templatesBasePath = __DIR__ . '/views';
        }

        $templatePath = "$templatesBasePath/$template.php";

        if ($useCoreTemplates === true) {
            require_once $templatePath;
        } else {
            require_once "$layoutsBasePath/$layout.php";
        }
    }

    public static function error(
        string $template = 'errors/exception',
        array $params = [],
        ?string $layout = null,
        bool $useCoreTemplates = true,
        int $httpResponseCode = 500
    ) {
        http_response_code($httpResponseCode);

        self::render($template, $params, $layout, $useCoreTemplates);
    }
}