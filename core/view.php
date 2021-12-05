<?php

namespace Core;

class View {

    public static function render(
        string $template,
        array $params = [],
        ?string $layout = null,
        bool $useCoreTemplates = false
    ) {
        /**
         * Standard-Layout laden, wenn kein $layout angegeben wurde.
         */
        if ($layout === null) {
            $layout = Config::get('app.default-layout', 'default');
        }

        if (!empty($params)) {
            extract($params);
        }

        /**
         * Pfade vorbereiten
         */
        $viewBasePath = __DIR__ . '/../resources/views';
        $layoutsBasePath = "{$viewBasePath}/layouts";
        $templatesBasePath = "{$viewBasePath}/templates";

        /**
         * Wenn im Core mitgelieferte Templates geladen werden sollen, so definieren wir den TemplateBasePath neu.
         */
        if ($useCoreTemplates === true) {
            $templatesBasePath = __DIR__ . '/views';
        }

        /**
         * Pfad zum Template definieren, das geladen werden soll.
         */
        $templatePath = "$templatesBasePath/$template.php";

        /**
         * Soll ein Template aus dem Core geladen werden, so laden wir es direkt, andernfalls laden wir das Layout,
         * welches dann wiederum das Template über den $templatePath lädt.
         */
        if ($useCoreTemplates === true) {
            require_once $templatePath;
        } else {
            require_once "$layoutsBasePath/$layout.php";
        }
    }

    /**
     * Hilfsfunktion, damit $useCoreTemplate direkt true ist und auch ein HTTP Status Code gesetzt werden kann.
     */
    public static function error(
        string $template = 'errors/exception',
        array $params = [],
        ?string $layout = null,
        bool $useCoreTemplates = true,
        int $httpResponseCode = 500
    ) {
        /**
         * Falls ein Fehler vorkommt, geben wir den Status 404 Not Found zurück.
         */
        http_response_code($httpResponseCode);

        /**
         * Hier rufen wir dann die render()-Methode von oben auf und laden wie immer einfach einen View.
         */
        self::render($template, $params, $layout, $useCoreTemplates);
    }
}