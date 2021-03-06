<?php

namespace Core;

class Validator {

    /**
     * Definieren der Datentypen, die validiert werden können. 
     */
    private array $types = [
        'letters' => '/^[a-zA-Zßäöü ]*$/i',
        'text' => '/^[a-zA-Zßäöü .,#\-_|;:?!]*$/i',
        'textnum' => '/^[\w\sßäöü .,#\-_|;:?!]*$/i',
        'alphanumeric' => '/^[^-_]{1}[a-zA-Z0-9-_]*$/',
        'password' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/',
        'email' => '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
        'ccexpire' => '/^(0[1-9]|1[0-2])\/?([0-9]{2})$/'
    ];

    /**
     * Definieren der numerischen Datentypen, die validiert werden können.
     */
    private array $numericTypes = [
        'numeric' => 'is_numeric',
        'int' => 'is_int',
        'float' => 'is_float'
    ];

    /**
     * Definieren der Fehlermeldungen für alle Datentypen oben. %s dient hier als Platzhalter.
     */
    private array $errorMessages = [
        'letters' => '%s may only include letters and spaces.',
        'text' => '%s may only include letters and special characters.',
        'textnum' => '%s may only consist of alphanumeric characters.',
        'alphanumeric' => '%s may only contain letters, numbers, hyphens and underscores.',
        'password' => '%s must be at least 8 characters long, contain upper and lower case letters and special characters.',
        'email' => '%s has to be a correct e-mail address.',
        'ccexpire' => '%s should be mm/yy',

        'numeric' => '%s has to be numeric.',
        'int' => '%s must be integer.', 
        'float' => '%s must be a floating point number.',

        'equals' => '%s has to be identical to %s.',
        'compare' => '%s and %s have to be identical.',
        'unique' => '%s is already being used.',

        'required' => '%s is a mandatory field.',
        'min' => '%s has to be at least %s long.',
        'min-string' => '%s has to be at least %s characters long.',
        'max' => '%s has to be less or equal to %s.',
        'max-string' => '%s may have a maximum of %s characters.',

    ];

    /**
     * Definieren einer Property, in die alle aufgetretenen Fehler gespeichert werden.
     */
    private array $errors = [];

    /**
     * Gesamte Validierung der Daten durchführen.
     */
    public function __call($name, $arguments) {
        /**
         * Namen der aufgerufenen Funktion laden, der ident sein sollte mit einem der Types.
         */
        $type = $name;
        /**
         * Werte aus dem Arguments-Array laden und mit Standardwerten auffüllen.
         */
        [$value, $label, $required, $min, $max] = $this->mergeDefaults($arguments);

        /**
         * Validierungen ausführen. Diese Methoden schreiben ihre Fehler in $this->errors.
         */
        $this->validateRequired($required, $value, $label);

        /**
         * Validierungen sollten nur dann durchgeführt werden, wenn das Formularfeld required ist oder wenn Daten
         * eingegeben wurden.
         */
        if ((bool)$required === true || !empty($value)) {
            $this->validateMin($type, $min, $value, $label);
            $this->validateMax($type, $max, $value, $label);

            /**
             * Wenn es sich um einen numerischen Typ handelt, so prüfen wir nicht mit einer Regular Expression.
             */
            if ($this->isNumericType($type)) {
                $this->validateNumericType($type, $value, $label);
            } else {
                $this->validateWithRegex($type, $value, $label);
            }
        }
    }

    /**
     * Hier prüfen wir, ob der aufgerufenen $type einer der oben definierten numericTypes ist.
     */
    private function isNumericType(string $type): bool {
        return array_key_exists($type, $this->numericTypes);
    }

    /**
     * Soll ein Eintrag aktualisiert werden, so muss die Unique-Prüfung auf alle anderen
     * Einträge ausgeführt werden und den aktuellen Eintrag ignorieren, da sonst ein
     * Validierungsfehler passieren würde, wenn der Wert in der Unique-Spalte für den zu
     * aktualisierenden Eintrag nicht geändert werden soll.
     */
    public function unique(string $value, string $label, string $table, string $column, int $ignoreThisId = 0): bool {
        /**
         * Datenbankverbindung herstellen.
         */
        $database = new Database();

        /**
         * Datenbank-Query bauen und counten, ob es schon ein Element mit $value in $column gibt.
         */
        $result = $database->query("SELECT COUNT(*) AS count FROM $table WHERE $column = ? AND id != ?", [
            's:value' => $value,
            'i:id' => $ignoreThisId
        ]);

        /**
         * Gibt es schon ein Element in der Datenbank, so counten wir mindestens 1 und schreiben daher einen Fehler.
         */
        if ($result[0]['count'] >= 1) {
            $this->errors[] = sprintf($this->errorMessages['unique'], $label);
            return false;
        }

        /**
         * Andernfalls geben wir true zurück.
         */
        return true;
    }

    /**
     * Hier vergleichen wir zwei Werte miteinander.
     */
    public function compare(array $valueAndLabel1, array $valueAndLabel2): bool {
        /**
         * Werte aus den beiden Arrays extrahieren.
         */
        [$value1, $label1] = $valueAndLabel1;
        [$value2, $label2] = $valueAndLabel2;

        /**
         * Stimmen die Werte nicht überein, so schrieben wir einen Fehler und geben false zurück.
         */
        if ($value1 !== $value2) {
            $this->errors[] = sprintf($this->errorMessages['compare'], $label1, $label2);
            return false;
        }

        /**
         * Andernfalls true zurückgeben.
         */
        return true;
    }

    /**
     * Diese Funktion hilft uns dabei, Standardwerte für alle Parameter in $arguments aus __call() zu setzen.
     */
    private function mergeDefaults(array $arguments): array {
        /**
         * Standardwerte definieren.
         */
        $defaults = [
            0 => 'text',
            'label' => 'Feld',
            'required' => false,
            'min' => null,
            'max' => null
        ];

        /**
         * Finales Array vorbereiten.
         */
        $mergedArguments = [];

        /**
         * Nun gehen wir alle Standardwerte durch ...
         */
        $i = 0;
        foreach ($defaults as $index => $value) {
            /**
             * ... und prüfen, ob an der selben Stelle im $arguments Array ein Wert steht.
             */
            if (isset($arguments[$index])) {
                /**
                 * Wenn ja, dann verwenden wir diesen Wert aus $arguments für $mergedArguments.
                 */
                $mergedArguments[$i] = $arguments[$index];
            } else {
                /**
                 * Wenn nein, verwenden wir den Wert aus $defaults, der durch die Schleife in $value liegt.
                 */
                $mergedArguments[$i] = $defaults[$index];
            }
            /**
             * Zähler erhöhen.
             */
            $i++;
        }

        /**
         * Fertiges Array zurückgeben, das Werte aus $arguments enthält und überall dort, wo keine Werte
         * übergeben wurden, weil sie optional waren, enthält es die Werte aus $defaults.
         */
        return $mergedArguments;
    }

    /**
     * Prüfen, ob ein Pflichtfeld ausgefüllt wurde.
     */
    private function validateRequired(bool $required, mixed $value, string $label): bool {
        /**
         * Wenn ein Feld verpflichtend ist, aber empty, schreiben wir einen Fehler und geben false zurück.
         */
        if ($required === true && empty($value)) {
            $this->errors[] = sprintf($this->errorMessages['required'], $label);
            return false;
        }
        /**
         * Andernfalls geben wir true zurück.
         */
        return true;
    }

    /**
     * Prüfen, ob der Mindestwert unterschritten wurde.
     */
    private function validateMin(mixed $type, ?int $min, mixed $value, mixed $label): bool {
        /**
         * Wurde $min gesetzt ...
         */
        if ($min !== null) {
            /**
             * ... so prüfen wir für numerische Typen direkt ...
             */
            if ($this->isNumericType($type) && $value < $min) {
                $this->errors[] = sprintf($this->errorMessages['min'], $label, $min);
                return false;
            }

            /**
             * ... und für string-basierte Typen die Länge des Strings.
             *
             * In beiden Fällen schreiben wir einen Fehler und geben false zurück im Fehlerfall.
             */
            if (!$this->isNumericType($type) && strlen($value) < $min) {
                $this->errors[] = sprintf($this->errorMessages['min-string'], $label, $min);
                return false;
            }
        }

        /**
         * Andernfalls geben wir true zurück.
         */
        return true;
    }

    /**
     * S. this->validateMin() nur umgekehrt.
     */
    private function validateMax(mixed $type, ?int $max, mixed $value, mixed $label): bool {
        if ($max !== null) {
            if ($this->isNumericType($type) && $value > $max) {
                $this->errors[] = sprintf($this->errorMessages['max'], $label, $max);
                return false;
            }

            if (!$this->isNumericType($type) && strlen($value) > $max) {
                $this->errors[] = sprintf($this->errorMessages['max-string'], $label, $max);
                return false;
            }
        }
        return true;
    }

    /**
     * Prüfen, ob der Wert auf die oben definierte Regex zutrifft.
     */
    private function validateWithRegex(string $type, mixed $value, string $label): bool {
        /**
         * Ist der gewünschte $type nicht in $this->types definiert, so liegt ein schwerer Fehler in der Programmierung
         * vor und wir werfen einen Exception.
         */
        if (!array_key_exists($type, $this->types)) {
            throw new \Exception("Type $type does not exists in Validator.");
        }

        /**
         * Regular Expression holen und prüfen mit der preg_match()-Funktion.
         */
        $typeRegex = $this->types[$type];
        if (preg_match($typeRegex, $value) !== 1) {
            /**
             * Findet preg_match() keinen Treffer oder tritt ein Fehler auf, so schreiben wir einen Fehler und geben
             * false zurück.
             */
            $this->errors[] = sprintf($this->errorMessages[$type], $label);
            return false;
        }

        /**
         * Andernfalls geben wir true zurück.
         */
        return true;
    }

    /**
     * Numerische Typen werden nicht über Regular Expression validiert, sondern mit den passenden PHP Funktionen.
     */
    private function validateNumericType(string $type, mixed $value, string $label): bool {
        /**
         * Hier holen wir uns den Namen der Funktion, mit der validiert werden soll.
         */
        $typeFunction = $this->numericTypes[$type];

        /**
         * Dann rufen wir diese Variable als Funktion auf und schreiben im Fehlerfall einen Fehler und geben false zurück.
         */
        if (!$typeFunction($value)) {
            $this->errors[] = sprintf($this->errorMessages[$type], $label);
            return false;
        }

        /**
         * Andernfalls geben wir true zurück.
         */
        return true;
    }

    /**
     * Hilfsfunktion, mit der wir prüfen können, ob im Zuge der Validierung Fehler aufgetreten sind.
     */
    public function hasErrors(): bool {
        if (empty($this->errors)) {
            return false;
        }
        return true;
    }

    /**
     * Nachdem $this->errors private ist, damit von außerhalb des Validators nicht darauf zugegriffen werden kann,
     * müssen wir irgendwie die Möglichkeit schaffen, die Fehler doch außerhalb zu bekommen.
     */
    public function getErrors(): array {
        return $this->errors;
    }
}