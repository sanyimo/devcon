<?php

namespace Controllers;

use Model\Day;
use Model\Hour;
use MVC\Router;
use Model\Event;
use Model\Speaker;
use Model\Category;
use Classes\Pagination;

class EventsController {

    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }

        $current_page = $_GET['page'];
        $current_page = filter_var($current_page, FILTER_VALIDATE_INT);

        if(!$current_page || $current_page < 1) {
            header('Location: /admin/events?page=1');
        }

        $per_page = 8;
        $total = Event::total();
        $pagination = new Pagination($current_page, $per_page, $total);

        $events = Event::paginate($per_page, $pagination->offset());

        foreach ($events as $i => $event) {

            $events[$i] = (object) array_merge($event->attributes(), [
                'category' => Category::find($event->category_id),
                'day' => Day::find($event->day_id),
                'hour' => Hour::find($event->hour_id),
                'speaker' => Speaker::find($event->speaker_id)
            ]);
        }

        $router->render('admin/events/index', [
            'title' => 'Conferencias y workshops',
            'events' => $events,
            'pagination' => $pagination->pagination()
        ]);
    }
    public static function create(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
            return;
        }
        $alerts = [];
        $categories = Category::all();
        $days = Day::all('ASC');
        $hours = Hour::all('ASC');

        $event = new Event;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
                return;
            }
            
            $event->syncronize($_POST);

            $alerts = $event->validate();

            if(empty($alerts)) {
                $result = $event->save();
                if($result) {
                    header('Location: /admin/events');
                    return;
                }
            }
        }
        $router->render('admin/events/create', [
            'title' => 'Registrar evento',
            'alerts' => $alerts,
            'categories' => $categories,
            'days' => $days,
            'hours' => $hours,
            'event' => $event
        ]);
    }
    
    public static function edit(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
            return;
        }

        $alerts = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/events');
            return;
        }

        $categories = Category::all('ASC');
        $days = Day::all('ASC');
        $hours = Hour::all('ASC');

        $event = Event::find($id);
        if(!$event) {
            header('Location: /admin/events');
            return;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
                return;
            }
            
            $event->syncronize($_POST);

            $alerts = $event->validate();

            if(empty($alerts)) {
                $result = $event->save();
                if($result) {
                    header('Location: /admin/events');
                    return;
                }
            }
        }

        $router->render('admin/events/edit', [
            'title' => 'Editar evento',
            'alerts' => $alerts,
            'categories' => $categories,
            'days' => $days,
            'hours' => $hours,
            'event' => $event
        ]);
    }
    public static function delete() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
                return;
            }

            $id = $_POST['id'];
            $event = Event::find($id);
            if(!isset($event) ) {
                header('Location: /admin/events');
                return;
            }
            $result = $event->delete();
            if($result) {
                header('Location: /admin/events');
                return;
            }
        }

    }
}