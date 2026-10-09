<?php

namespace Controllers;

use MVC\Router;
use Model\Event;
use Model\User;
use Model\Record;

class DashboardController {

    public static function index(Router $router) {

        // Get the latest registrations
        $records = Record::get(4);
        foreach ($records as $index => $record) {
            // Store the related user in a separate collection to avoid assigning
            // an undeclared property on the ActiveRecord model.
            $users[$index] = User::find($record->user_id);
        }

        // Calculate the revenue
        $virtuals = Record::total('pack_id', 2);
        $presentials = Record::total('pack_id', 1);

        $income = ($virtuals * 46.98) + ($presentials * 191.88); // PayPal commission deducted

        // Get events with the most and fewest available spots
        $less_availables = Event::orderLimit('availables', 'ASC', 4);
        $more_availables = Event::orderLimit('availables', 'DESC', 4);

        $router->render('admin/dashboard/index', [
            'title' => t('Panel de administración'),
            'records' => $records,
            'users' => $users ?? [],
            'income' => $income,
            'less_availables' => $less_availables,
            'more_availables' => $more_availables
        ]);
    }
}