<?php

namespace Controllers;

use MVC\Router;
use Model\Gift;

class GiftsController {

    public static function index(Router $router) {
        $gifts = Gift::all('ASC');

        foreach ($gifts as $gift) {
            $gift->reserved = Gift::reservations($gift->id);
            $gift->availables = $gift->quantity - $gift->reserved;
        }

        $router->render('admin/gifts/index', [

            'title' => t('Regalos'),
            'gifts' => $gifts

        ]);
    }

    public static function create(Router $router) {
        if (!is_admin()) {
            header('Location: /login');
        }

        $alerts = [];
        $gift = new Gift;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }

            $gift->syncronize($_POST);

            // Validate
            $alerts = $gift->validate();

            // Save the record
            if (empty($alerts)) {
                $gift->save();
                header('Location: /admin/gifts');
            }
        }

        $router->render('admin/gifts/create', [
            'title' => t('Registrar regalo'),
            'alerts' => $alerts,
            'gift' => $gift

        ]);
    }

    public static function edit(Router $router) {
        if (!is_admin()) {
            header('Location: /login');
        }

        $alerts = [];

        // Validate the ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/gifts');
        }

        // Get the gift to edit
        $gift = Gift::find($id);

        if (!$gift) {
            header('Location: /admin/gifts');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }

            $gift->syncronize($_POST);
            $alerts = $gift->validate();

            if (empty($alerts)) {
                $result = $gift->save();

                if ($result) {
                    header('Location: /admin/gifts');
                }
            }
        }

        $router->render('admin/gifts/edit', [
            'title' => t('Actualizar regalo'),
            'alerts' => $alerts,
            'gift' => $gift
        ]);
    }

    public static function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_admin()) {
                header('Location: /login');
            }

            $id = $_POST['id'];
            $gift = Gift::find($id);

            if (!isset($gift)) {
                header('Location: /admin/gifts');
            }

            $result = $gift->delete();

            if ($result) {
                header('Location: /admin/gifts');
            }
        }
    }
}