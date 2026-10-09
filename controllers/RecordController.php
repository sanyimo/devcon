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

        if(isset($_GET['view']) && $_GET['view'] === 'ticket') {
            $records = Record::whereArray(['user_id' => $_SESSION['id']]);

            foreach($records as $record) {
                $record->user = User::find($record->user_id);
                $record->pack = Pack::find($record->pack_id);
            }

            $router->render('record/ticket', [
                'title' => t('Asistencia a DevCon'),
                'records' => $records,
                'preview' => true
            ]);
            return;
        }

        $router->render('record/create', [
            'title' => t('Tickets & Precios')
        ]);
    }

    public static function free(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()) {
                header('Location: /login');
                return;
            }

            // Check whether the user is already registered
            $record = Record::where('user_id', $_SESSION['id']);
            if(isset($record) && $record->pack_id === "3") {
                header('Location: /ticket?id=' . urlencode($record->token));
                return;
            }

            $token = substr( md5(uniqid( rand(), true )), 0, 8);

            // Create the registration
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

    public static function manage(Router $router) {
        if(!is_auth()) {
            header('Location: /login');
            return;
        }

        $records = Record::whereArray(['user_id' => $_SESSION['id']]);

        foreach($records as $record) {
            $record->pack = Pack::find($record->pack_id);
        }

        $gifts = Gift::all('ASC');

        foreach($gifts as $gift) {
            $gift->availables = (int) $gift->quantity - Gift::reservations($gift->id);
        }

        $router->render('record/manage', [
            'title' => t('Administrar'),
            'records' => $records,
            'gifts' => $gifts
        ]);
    }

    public static function updateGift() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_auth()) {
            header('Location: /manage');
            return;
        }

        $token = $_POST['token'] ?? '';
        $gift_id = filter_var($_POST['gift_id'] ?? '', FILTER_VALIDATE_INT);

        $record = $token ? Record::where('token', $token) : null;

        if(!$record || (string) $record->user_id !== (string) $_SESSION['id'] || !$gift_id) {
            header('Location: /manage');
            return;
        }

        $gift = Gift::find($gift_id);

        if(!$gift) {
            header('Location: /manage');
            return;
        }

        $reserved = Gift::reservations($gift->id);

        if((string) $record->gift_id !== (string) $gift->id && $reserved >= (int) $gift->quantity) {
            header('Location: /manage');
            return;
        }

        $record->gift_id = $gift->id;
        $record->save();

        header('Location: /manage');
    }

    public static function cancel() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_auth()) {
            header('Location: /manage');
            return;
        }

        $token = $_POST['token'] ?? '';

        if(!$token) {
            header('Location: /manage');
            return;
        }

        $record = Record::where('token', $token);

        if(!$record || (string) $record->user_id !== (string) $_SESSION['id']) {
            header('Location: /manage');
            return;
        }

        $registries = EventsRegistry::whereArray(['record_id' => $record->id]);

        foreach($registries as $registry) {
            $event = Event::find($registry->event_id);

            if($event) {
                $event->availables += 1;
                $event->save();
            }

            $registry->delete();
        }

        $record->delete();

        header('Location: /manage');
    }

    public static function ticket(Router $router) {

        // Validate the URL
        $id = $_GET['id'];

        if(!$id || !strlen($id) === 8 ) {
            header('Location: /');
            return;
        }

        // Find it in the database
        $record = Record::where('token', $id);
        if(!$record) {
            header('Location: /');
            return;
        }
        // Load the related records
        $record = (object) array_merge((array) $record, [
            'user' => User::find($record->user_id),
            'pack' => Pack::find($record->pack_id)
        ]);

        $router->render('record/ticket', [
            'title' => t('Asistencia a DevCon'),
            'record' => $record
        ]);
    }

    public static function purchase(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()) {
                header('Location: /login');
                return;
            }

            // Validate that POST is not empty
            if(empty($_POST)) {
                echo json_encode([]);
                return;
            }

            // Create the registration
            $data = $_POST;
            $data['token'] = substr( md5(uniqid( rand(), true )), 0, 8); // Start and end, 0-8
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

        // Validate that the user has the in-person plan
        $user_id = $_SESSION['id'];
        $token = $_GET['token'] ?? '';
        $record = $token
            ? Record::where('token', $token)
            : Record::where('user_id', $user_id);

        if(!$record || (string) $record->user_id !== (string) $user_id || $record->pack_id !== "1") {
            header('Location: /');
            return;
        }

        // Redirect to the virtual ticket if registration is complete
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

        foreach($gifts as $gift) {
            $gift->availables = (int) $gift->quantity - Gift::reservations($gift->id);
        }

        // Handle registration through $_POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Check that the user is authenticated
            if(!is_auth()) {
                header('Location: /login');
                return;
            }

            $events = explode(',', $_POST['events']);
            if(empty($events)) {
                echo json_encode(['result' => false]);
                return;
            }

            // Get the user registration
            $record = Record::where('user_id', $_SESSION['id']);
            if(!isset($record) || $record->pack_id !== "1") {
                echo json_encode(['result' => false]);
                return;
            }

            $events_array = [];
            // 1. Validate availability for the selected events
            foreach($events as $event_id) {
                $event = Event::find($event_id);
                // Check whether the event exists
                if(!isset($event) || $event->availables === "0") {
                    echo json_encode(['result' => false]);
                    return;
                }
                $events_array[] = $event;
            }
            // 2. Decrease availability and save
            foreach($events_array as $event) {
                $event->availables -= 1;
                $event->save();

                // Store the registration
                $data = [
                    'event_id' =>  (int) $event->id,
                    'record_id' => (int)  $record->id
                ];

                $record_user = new EventsRegistry($data);
                $record_user->save();
            }

            // Store the gift
            $gift_id = filter_var($_POST['gift_id'] ?? '', FILTER_VALIDATE_INT);
            $gift = $gift_id ? Gift::find($gift_id) : null;

            if(!$gift || Gift::reservations($gift->id) >= (int) $gift->quantity) {
                echo json_encode(['result' => false]);
                return;
            }

            $record->syncronize(['gift_id' => $gift->id]);
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
            'title' => t('Elige Workshops y Conferencias'),
            'events' => $events_formatted,
            'gifts' => $gifts
        ]);

        // Redirect to the virtual ticket if registration is complete
        if(isset($record->gift_id) && $record->pack_id === "1") {
            header('Location: /ticket?id=' . urlencode($record->token));
            return;
        }
    }
}