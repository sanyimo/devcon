<?php

namespace Controllers;

use Model\Day;
use Model\Hour;
use MVC\Router;
use Model\Event;
use Model\Gift;
use Model\Pack;
use Model\Speaker;
use Model\User;
use Model\Record;
use Model\Category;
use Model\EventsRegistry;

class RecordController {
    public static function create(Router $router) {
        if(!is_auth()) {
            header('Location: /');
            return;
        }

        // Verificar si el usuario ya esta registrado
        $record = Record::where('user_id', $_SESSION['id']);

        if(isset($record) && ($record->pack_id === "3" || $record->pack_id === "2" )) {
            header('Location: /ticket?id=' . urlencode($record->token));
            return;
        }

        if(isset($record) && $record->pack_id === "1") {
            header('Location: /finish-record/conferences');
            return;
        }

        $router->render('record/create', [
            'title' => 'Finalizar registro'
        ]);
    }
    public static function free(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()) {
                header('Location: /login');
                return;
            }

            // Verificar si el usuario ya esta registrado
            $record = Record::where('user_id', $_SESSION['id']);
            if(isset($record) && $record->pack_id === "3") {
                header('Location: /ticket?id=' . urlencode($record->token));
                return;
            }

            $token = substr( md5(uniqid( rand(), true )), 0, 8);

            // Crear registro
            $data = [
                'pack_id' => 3,
                'payment_id' => '',
                'token' => $token,
                'user_id' => $_SESSION['id']
            ];

            $record = new Record($data);
            $result = $record->save();
            
            if($result) {
                header('Location: /ticket?id=' . urlencode($record->token));
                return;
            }
        }
    }

    public static function ticket(Router $router) {

        // Validar la URL
        $id = $_GET['id'];

        if(!$id || !strlen($id) === 8 ) {
            header('Location: /');
            return;
        }

        // buscarlo en la BD
        $record = Record::where('token', $id);
        if(!$record) {
            header('Location: /');
            return;
        }
        // Llenar las tablas de referencia
        $record = (object) array_merge((array) $record, [
            'user' => User::find($record->user_id),
            'pack' => Pack::find($record->pack_id)
        ]);

        $router->render('record/ticket', [
            'title' => 'Asistencia a DevCon',
            'record' => $record
        ]);
    }
    public static function purchase(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()) {
                header('Location: /login');
                return;
            }

            // Validar que Post no venga vacio
            if(empty($_POST)) {
                echo json_encode([]);
                return;
            }

            // Crear el registro
            $data = $_POST;
            $data['token'] = substr( md5(uniqid( rand(), true )), 0, 8); //inicio y final, 0-8
            $data['user_id'] = $_SESSION['id'];
            
            try {
                $record = new Record($data);
          
                $result = $record->save();
                echo json_encode($result);
            } catch (\Throwable $th) {
                echo json_encode([
                    'result' => 'error'
                ]);
            }
        }
    }
    public static function conferences(Router $router) {

        if(!is_auth()) {
            header('Location: /login');
            return;
        }        

        // Validar que el usuario tenga el plan presencial
        $user_id = $_SESSION['id'];
        $record = Record::where('user_id', $user_id);

        if(isset($record) && $record->pack_id === "2") {
            header('Location: /ticket?id=' . urlencode($record->token));
            return;
        }
        
        if($record->pack_id !== "1") {
            header('Location: /');
            return;
        }

        // Redireccionar a ticket virtual en caso de haber finalizado su registro
        // if(isset($record->gift_id) && $record->pack_id === "1") {
        //     header('Location: /ticket?id=' . urlencode($record->token));
        //     return;
        // }

        $events = Event::order('hour_id', 'ASC');

        $events_formatted = [];
        foreach($events as $event) {
            $formatted_event = (object) array_merge((array) $event, [
                'category' => Category::find($event->category_id),
                'day' => Day::find($event->day_id),
                'hour' => Hour::find($event->hour_id),
                'speaker' => Speaker::find($event->speaker_id)
            ]);
            
            if($formatted_event->day_id === "1" && $formatted_event->category_id === "1") {
                $events_formatted['conferences'][] = $formatted_event;
            }

            if($formatted_event->day_id === "2" && $formatted_event->category_id === "1") {
                $events_formatted['conferences'][] = $formatted_event;
            }

            if($formatted_event->day_id === "1" && $formatted_event->category_id === "2") {
                $events_formatted['workshops_v'][] = $formatted_event;
            }

            if($formatted_event->day_id === "2" && $formatted_event->category_id === "2") {
                $events_formatted['workshops_s'][] = $formatted_event;
            }
        }
        $gifts = Gift::all('ASC');

        // Manejando el registro mediante $_POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Revisar que el usuario este autenticado
            if(!is_auth()) {
                header('Location: /login');
                return;
            }

            $events = explode(',', $_POST['events']);
            if(empty($events)) {
                echo json_encode(['result' => false]);
                return;
            }

            // Obtener el registro de usuario
            $record = Record::where('user_id', $_SESSION['id']);
            if(!isset($record) || $record->pack_id !== "1") {
                echo json_encode(['result' => false]);
                return;
            }

            $events_array = [];
            //1. Validar la disponibilidad de los events seleccionados
            foreach($events as $event_id) {
                $event = Event::find($event_id);
                //Check if event exists
                if(!isset($event) || $event->availables === "0") {
                    echo json_encode(['result' => false]);
                    return;
                }
                $events_array[] = $event;
            }
            //2.restar y guardar
            foreach($events_array as $event) {
                $event->availables -= 1;
                $event->save();

                // Almacenar el registro
                $data = [
                    'event_id' =>  (int) $event->id,
                    'record_id' => (int)  $record->id
                ];

                $record_user = new EventsRegistry($data);
                $record_user->save();
            }

            // Almacenar el regalo
            $record->syncronize(['gift_id' => $_POST['gift_id']]);
            $result = $record->save();

            if($result) {
                echo json_encode([
                    'result' => $result, 
                    'token' => $record->token
                ]);
            } else {
                echo json_encode(['result' => false]);
            }
            return;
        }

        $router->render('record/conferences', [
            'title' => 'Elige Workshops y Conferencias',
            'events' => $events_formatted,
            'gifts' => $gifts
        ]);

        // Redireccionar a ticket virtual en caso de haber finalizado su registro
        if(isset($record->gift_id) && $record->pack_id === "1") {
            header('Location: /ticket?id=' . urlencode($record->token));
            return;
        }
    }
}