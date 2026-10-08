<?php

namespace Controllers;

use MVC\Router;
use Model\Speaker;
use Classes\Pagination;
use Intervention\Image\ImageManagerStatic as Image;

class SpeakersController {

    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }

        $current_page = $_GET['page'];
        $current_page = filter_var($current_page, FILTER_VALIDATE_INT);

        if(!$current_page || $current_page < 1) {
            header('Location: /admin/speakers?page=1');
        }
        $records_per_page = 5;
        $total = Speaker::total();

        //$current_page = 1;
        //$records_per_page = 10;
        //$total = 10;
        $pagination = new Pagination($current_page, $records_per_page, $total);

        if($pagination->total_pages() < $current_page) {
            header('Location: /admin/speakers?page=1');
        }

        $speakers = Speaker::paginate($records_per_page, $pagination->offset());

        $router->render('admin/speakers/index', [
            'title' => 'Ponentes / Conferenciantes',
            'speakers' => $speakers,
            'pagination' => $pagination->pagination()
        ]);
    }
    public static function create(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }

        $alerts = [];
        $speaker = new Speaker;
        $images_folder = '../public/img/speakers';

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
            }
            $image_name = null;
            // Read image
            if(!empty($_FILES['image']['tmp_name'])) {
                
                // Crear la carpeta si no existe
                if(!is_dir($images_folder)) {
                    mkdir($images_folder, 0755, true);
                }
                $image_png = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('png', 80);
                $image_webp = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $image_name = md5( uniqid( rand(), true) );

                $_POST['image'] = $image_name;
            } 

            $_POST['social_networks'] = json_encode( $_POST['social_networks'], JSON_UNESCAPED_SLASHES );//llega como un string y no como arreglo

            $speaker->syncronize($_POST);

            // validar
            $alerts = $speaker->validate();

             // Guardar el registro
             if(empty($alerts)) {

                // Save images
                if(isset($image_png, $image_webp)) {
                    $image_png->save($images_folder . '/' . $image_name . ".png" );
                    $image_webp->save($images_folder . '/' . $image_name . ".webp" );
                }

                // Guardar en la BD
                $speaker->save();
                header('Location: /admin/speakers');
             }
        }
        
        $router->render('admin/speakers/create', [
            'title' => 'Registrar ponente',
            'aleras' => $alerts,
            'speaker' => $speaker,
            'social_networks' => json_decode($speaker->social_networks)
        ]);
    }

    public static function edit(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        $alerts = [];
        $images_folder = '../public/img/speakers';
        // Validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/speakers');
        }

        // Obtener ponente a Editar
        $speaker = Speaker::find($id);

        if(!$speaker) {
            header('Location: /admin/speakers');
        }
        $speaker->current_image = $speaker->image;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
            }
            // Read image
            if(!empty($_FILES['image']['tmp_name'])) {
                
                // Crear la carpeta si no existe
                if(!is_dir($images_folder)) {
                    mkdir($images_folder, 0755, true);
                }
                $image_png = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('png', 80);
                $image_webp = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $image_name = md5( uniqid( rand(), true) );

                $_POST['image'] = $image_name;
            } else {
                $_POST['image'] = $speaker->image_name;
            }
            $_POST['social_networks'] = json_encode( $_POST['social_networks'], JSON_UNESCAPED_SLASHES );     
            $speaker->syncronize($_POST);

            $alerts = $speaker->validate();

            if(empty($alerts)) {
                if(isset($image_png, $image_webp, $image_name)) {
                    $image_png->save($images_folder . '/' . $image_name . ".png" );
                    $image_webp->save($images_folder . '/' . $image_name . ".webp" );
                }
                $result = $speaker->save();
                if($result) {
                    header('Location: /admin/speakers');
                }
            }
        }

        $router->render('admin/speakers/edit', [
            'title' => 'Actualizar ponente',
            'alerts' => $alerts,
            'speaker' => $speaker,
            'social_networks' => json_decode($speaker->social_networks)
        ]);
    }
    public static function delete() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
            }

            $id = $_POST['id'];
            $speaker = Speaker::find($id);
            if(!isset($speaker) ) {
                header('Location: /admin/speakers');
            }
            $result = $speaker->delete();
            if($result) {
                header('Location: /admin/speakers');
            }
        }
    }
}