<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIEvents;
use Controllers\APIGifts;
use Controllers\APISpeakers;
use Controllers\AuthController;
use Controllers\EventsController;
use Controllers\PagesController;
use Controllers\GiftsController;
use Controllers\SpeakersController;
use Controllers\RecordController;
use Controllers\DashboardController;
use Controllers\RecordedController;

$router = new Router();


// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Create account
$router->get('/register', [AuthController::class, 'record']);
$router->post('/register', [AuthController::class, 'record']);

// Forgot password form
$router->get('/forgot', [AuthController::class, 'forgot']);
$router->post('/forgot', [AuthController::class, 'forgot']);

// Set new password
$router->get('/restore', [AuthController::class, 'restore']);
$router->post('/restore', [AuthController::class, 'restore']);

// Account confirmation
$router->get('/message', [AuthController::class, 'message']);
$router->get('/confirm-account', [AuthController::class, 'confirm']);

// Admin area
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/speakers', [SpeakersController::class, 'index']);
$router->get('/admin/speakers/create', [SpeakersController::class, 'create']);
$router->post('/admin/speakers/create', [SpeakersController::class, 'create']);
$router->get('/admin/speakers/edit', [SpeakersController::class, 'edit']);
$router->post('/admin/speakers/edit', [SpeakersController::class, 'edit']);
$router->post('/admin/speakers/delete', [SpeakersController::class, 'delete']);


$router->get('/admin/events', [EventsController::class, 'index']);
$router->get('/admin/events/create', [EventsController::class, 'create']);
$router->post('/admin/events/create', [EventsController::class, 'create']);
$router->get('/admin/events/edit', [EventsController::class, 'edit']);
$router->post('/admin/events/edit', [EventsController::class, 'edit']);
$router->post('/admin/events/delete', [EventsController::class, 'delete']);

$router->get('/api/events-schedule', [APIEvents::class, 'index']);
$router->get('/api/speakers', [APISpeakers::class, 'index']);
$router->get('/api/speaker', [APISpeakers::class, 'speaker']);
$router->get('/api/gifts', [APIGifts::class, 'index']);

$router->get('/admin/recorded', [RecordedController::class, 'index']);

$router->get('/admin/gifts', [GiftsController::class, 'index']);
$router->get('/admin/gifts/create', [GiftsController::class, 'create']);
$router->post('/admin/gifts/create', [GiftsController::class, 'create']);
$router->get('/admin/gifts/edit', [GiftsController::class, 'edit']);
$router->post('/admin/gifts/edit', [GiftsController::class, 'edit']);
$router->post('/admin/gifts/delete', [GiftsController::class, 'delete']);

// User registration
$router->get('/purchase', [RecordController::class, 'create']);
$router->post('/purchase/free', [RecordController::class, 'free']);
$router->post('/purchase', [RecordController::class, 'purchase']);
$router->get('/purchase/conferences', [RecordController::class, 'conferences']);
$router->post('/purchase/conferences', [RecordController::class, 'conferences']);

// Account management
$router->get('/manage', [RecordController::class, 'manage']);
$router->post('/unregister', [AuthController::class, 'unregister']);
$router->post('/cancel-ticket', [RecordController::class, 'cancel']);
$router->post('/manage/gift', [RecordController::class, 'updateGift']);

// Virtual ticket
$router->get('/ticket', [RecordController::class, 'ticket']);

// Public area
$router->get('/', [PagesController::class, 'index']);
$router->get('/devcon', [PagesController::class, 'event']);
$router->get('/packs', [PagesController::class, 'packs']);
$router->get('/workshops-conferences', [PagesController::class, 'conferences']);
$router->get('/404', [PagesController::class, 'error']);

$router->checkRoutes();