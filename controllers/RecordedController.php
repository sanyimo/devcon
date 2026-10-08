<?php

namespace Controllers;

use MVC\Router;
use Model\Pack;
use Model\User;
use Model\Record;
use Classes\Pagination;

class RecordedController {

    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        $current_page = $_GET['page'];
        $current_page = filter_var($current_page, FILTER_VALIDATE_INT);

        if(!$current_page || $current_page < 1) {
            header('Location: /admin/recorded?page=1');
        }
        $records_per_page = 10;
        $total = Record::total();
        $pagination = new Pagination($current_page, $records_per_page, $total);


        if($pagination->total_pages() < $current_page) {
            header('Location: /admin/recorded?page=1');
        } 

        $records = Record::paginate($records_per_page, $pagination->offset());
        foreach($records as $recordIndex => $record) {
            $records[$recordIndex] = (object) array_merge((array) $record, [
                'user' => User::find($record->user_id),
                'pack' => Pack::find($record->pack_id)
            ]);
        }

        $router->render('admin/recorded/index', [
            'title' => t('Usuarios registrados'),
            'records' => $records,
            'pagination' => $pagination->pagination()
        ]);
    }

}