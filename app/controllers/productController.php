<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Helpers\Redirector;
use Core\Middlewares\AuthMiddleware;
use Core\Session;
use Core\Validator;
use Core\View;
use Core\Models\File;

class ProductController {

    /**
     * Index Seite anzeigen
     */
    public function index() {
        $products = Product::all();

        View::render('products/index', [
            'products' => $products
        ]);
    }

    /**
     * Produktübersichtsseite anzeigen
     */
    public function show(int $id)
    {
        $product = Product::findOrFail($id);

        View::render('products/details', [
            'product' => $product
        ]);
    }

    /**
     * Bearbeitungsformular für Admins anzeigen
     */
    public function edit(int $id)
    {
        /**
         * Prüfen, ob ein*e User*in eingeloggt ist und ob diese*r eingeloggte User*in Admin ist.
         */
      
        AuthMiddleware::isAdminOrFail();
        /**
         * Gewünschtes Element über das zugehörige Model aus der Datenbank laden.
         */
        $product = Product::findOrFail($id);

        /**
         * View laden und Daten übergeben.
         */
        View::render('products/edit', [
            'product' => $product
        ]);
    }

    /**
     * Formulardaten aus dem Bearbeitungsformular entgegennehmen und verarbeiten.
     */
    public function update(int $id) {
        /**
         * Prüfen ob der/die User*in eigeloggt ist und ob diese*r User ein Admin ist.
         */
        AuthMiddleware::isAdminOrFail();

        /**
         * Validierung aus der Methode durchführen
         */
        $validationErrors = $this->validateFormData();

        /**
         * Wenn Validierungsfehler aufgetreten sind, speichern wir sie in die Session 
         * und redirecten zum Bearbeitungsformular.
         */
        if (!empty($validationErrors)) {
            Session::set('errors', $validationErrors);
            Redirector::redirect("/products/${id}");
        }

        /**
         * Ausgewähltes Produkt aus der DB laden.
         */
        $product = Product::findOrFail($id);

        /**
         * Sind keine Fehler aufgetreten, aktualisieren wir die Werte des vorher geladenen Objekts
         */
        $product->fill($_POST);

        $product = $this->handleUploadedFiles($product);
        $product = $this->handleDeletedFiles($product);
        
        /**
         * Hat die Speicherung nicht funktioniert, speichern wir den Fehler in die Session.
         */
        if (!$product->save()) {
            Session::set('errors', ['Failed to save.']);
        } else {
            Session::set('success', ['Product successfully updated.']);
        }

        /**
         * Hat alles funktioniert, so leiten wir zu der Home Seite.
         */
        Redirector::redirect("/products");
    }

    /**
     * Produkt löschen
     */
    public function delete(int $id)
    {
        /**
         * Prüfen ob der/die User*in eigeloggt ist und ob diese*r User ein Admin ist.
         */
        AuthMiddleware::isAdminOrFail();

        /**
         * Ausgewähltes Produkt aus der DB laden.
         */
        $product = Product::findOrFail($id);

        /**
         * Produkt löschen
         */
        $product->delete();

        /**
         * Erfolgsmeldung in die Session speichern und zurück zur Produkt Seite leiten.
         */
        Session::set('success', ['Product was deleted successfully.']);
        Redirector::redirect('/products');
    }

    /**
     * Erstellungsformular anzeigen
     */
    public function create()
    {
        /**
         * Prüfen ob der/die User*in eigeloggt ist und ob diese*r User ein Admin ist.
         */
        AuthMiddleware::isAdminOrFail();

        /**
         * Alle Produkte laden
         */
        $products = Product::all();

        /**
         * View laden und Daten übergeben.
         */
        View::render('products/create', [
            'products' => $products
        ]);
    }

    /**
     * Formulardaten aus dem Erstellungsformular entgegennehmen und verarbeiten.
     */
    public function store()
    {
        /**
         * Prüfen ob der/die User*in eigeloggt ist und ob diese*r User ein Admin ist.
         */
        AuthMiddleware::isAdminOrFail();

        /**
         * Validierung aus der Methode durchführen
         */
        $validationErrors = $this->validateFormData();

        /**
         * Wenn Validierungsfehler aufgetreten sind, speichern wir sie in die Session 
         * und redirecten zum Bearbeitungsformular.
         */
        if (!empty($validationErrors)) {
            Session::set('errors', $validationErrors);
            Redirector::redirect("/products/create");
        }

        /**
         * Neues Produkt erstellen und mit den Daten aus dem Formular befüllen.
         */
        $product = new Product();
        $product->fill($_POST);
        $product = $this->handleUploadedFiles($product);

        /**
         * Schlägt die Speicherung aus irgendeinem Grund fehl ...
         */
        if (!$product->save()) {
            /**
             * ... so speichern wir einen Fehler in die Session und leiten wieder zurück zum Bearbeitungsformular.
             */
            Session::set('errors', ['Speichern fehlgeschlagen.']);
            Redirector::redirect("/products/create");
        }

        /**
         * Wenn alles funktioniert hat, leiten wir zurück zur /home-Route.
         */
        Redirector::redirect('/products');
    }

    /**
     * Validierungsmethode erstellen, damit wir sie nicht mehrmals schreiben müssen, sondern einfach anwenden können.
     */
    private function validateFormData(): array
    {
        /**
         * Neues Validator Objekt erstellen.
         */
        $validator = new Validator();

        /**
         * Gibt es überhaupt Daten, die validiert werden können?
         */
        if (!empty($_POST)) {
            /**
             * Daten validieren.
             */
            
            $validator->textnum($_POST['name'], label: 'Name', required: true, max: 255);
            $validator->text($_POST['description'], label: 'Description');
        }

        /**
         * Fehler aus dem Validator zurückgeben.
         */
        return $validator->getErrors();
    }

    public function handleUploadedFiles(Product $product) : ?product {
        /**
         * Wir erstellen zunächst einen Array an Objekten, damit wir Logik, die zu einer Datei gehört, in diesen
         * Objekten kapseln können.
         */
        $file = File::createFromUploadedFile('images');

        /**
         * Nun gehen wir alle Dateien durch ...
         */
            /**
             * ... speichern sie in den Uploads Ordner ...
             */
            $storagePath = $file->putToUploadsFolder();
            /**
             * ... und verknüpfen sie mit dem Raum.
             */
            // $product->addImages([$storagePath]);
            $product->images = basename($storagePath);
        /**
         * Nun geben wir den aktualisierten Produkt wieder zurück.
         */
        return $product;
    }

    /**
     * Löschen-Checkboxen der Bilder eines Produkts verarbeiten.
     */
    private function handleDeletedFiles(Product $product): Product
    {
        /**
         * Wir prüfen, ob eine der Checkboxen angehakerlt wurde.
         */
        if (isset($_POST['delete-images'])) {
            /**
             * Wenn ja, gehen wir alle Checkboxen durch ...
             */
            foreach ($_POST['delete-images'] as $deleteImage) {
                /**
                 * Lösen die Verknüpfung zum Produkt ...
                 */
                $product->removeImages([$deleteImage]);
                /**
                 * ... und löschen die Datei aus dem Uploads-Ordner.
                 */
                File::delete($deleteImage);
            }
        }

        /**
         * Nun geben wir den gelöschten Produkt wieder zurück.
         */
        return $product;
    }
}