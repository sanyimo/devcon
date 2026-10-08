<?php
namespace Controllers;

use Model\Day;
use Model\Hour;
use MVC\Router;
use Model\Event;
use Model\Speaker;
use Model\Category;

class PagesController {
    public static function index(Router $router) {
        $events = Event::order('hour_id', 'ASC');

        $events_formatted = [];

        foreach($events as $event) {
            $formatted_event = (object) (array) $event;
            $formatted_event->category = Category::find($event->category_id);
            $formatted_event->day = Day::find($event->day_id);
            $formatted_event->hour = Hour::find($event->hour_id);
            $formatted_event->speaker = Speaker::find($event->speaker_id);
            
            if($formatted_event->day_id === "1" && $formatted_event->category_id === "1") {
                $events_formatted['conferences_v'][] = $formatted_event;
            }

            if($formatted_event->day_id === "2" && $formatted_event->category_id === "1") {
                $events_formatted['conferences_s'][] = $formatted_event;
            }

            if($formatted_event->day_id === "1" && $formatted_event->category_id === "2") {
                $events_formatted['workshops_v'][] = $formatted_event;
            }

            if($formatted_event->day_id === "2" && $formatted_event->category_id === "2") {
                $events_formatted['workshops_s'][] = $formatted_event;
            }
        }

        // Get the total for each block
        $speakers_total = Speaker::total();
        $conferences_total = Event::total('category_id', 1);
        $workshops_total = Event::total('category_id', 2);

        // Get all speakers
        $speakers = Speaker::all();

        $router->render('pages/index', [
            'title' => t('Inicio'),
            'events' => $events_formatted,
            'speakers_total' => $speakers_total,
            'conferences_total' => $conferences_total,
            'workshops_total' => $workshops_total,
            'speakers' => $speakers
        ]);
    }
    public static function event(Router $router) {

        $router->render('pages/devcon', [
            'title' => t('Sobre DevCon')
        ]);
    }
    public static function packs(Router $router) {

        $router->render('pages/packs', [
            'title' => t('Paquetes DevCon')
        ]);
    }
    public static function conferences(Router $router) {
        // $events = Event::where('category_id', 1);
        // $events = Event::where('category_id', 2);
        $events = Event::order('hour_id', 'ASC');

        $events_formatted = [];
        foreach($events as $event) {
            $formatted_event = (object) (array) $event;
            $formatted_event->category = Category::find($event->category_id);
            $formatted_event->day = Day::find($event->day_id);
            $formatted_event->hour = Hour::find($event->hour_id);
            $formatted_event->speaker = Speaker::find($event->speaker_id);
            
            if($formatted_event->day_id === "1" && $formatted_event->category_id === "1") {
                $events_formatted['conferences_v'][] = $formatted_event;
            }

            if($formatted_event->day_id === "2" && $formatted_event->category_id === "1") {
                $events_formatted['conferences_s'][] = $formatted_event;
            }

            if($formatted_event->day_id === "1" && $formatted_event->category_id === "2") {
                $events_formatted['workshops_v'][] = $formatted_event;
            }

            if($formatted_event->day_id === "2" && $formatted_event->category_id === "2") {
                $events_formatted['workshops_s'][] = $formatted_event;
            }
        }

        $router->render('pages/conferences', [
            'title' => t('conferences & Workshops'),
            'events' => $events_formatted
        ]);
    }
    public static function error(Router $router) {

        $router->render('pages/error', [
            'title' => t('Página no encontrada')
        ]);
    }
}