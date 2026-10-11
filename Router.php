<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get(string $url, callable $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post(string $url, callable $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function checkRoutes()
    {

        $current_url = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        if (session_status() !== PHP_SESSION_ACTIVE && isset($_COOKIE[session_name()])) {
            session_start();
        }

        if (!empty($_SESSION['demo'])) {
            $allowedRequest = $method === 'GET'
                || ($method === 'POST' && $current_url === '/logout');

            if (!$allowedRequest) {
                http_response_code(403);
                exit('Forbidden');
            }
        }

        if ($method === 'GET') {
            $fn = $this->getRoutes[$current_url] ?? null;
        } else {
            $fn = $this->postRoutes[$current_url] ?? null;
        }

        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            header('Location: /404');
        }
    }

    public function render(string $view, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $$key = $value; 
        }

        ob_start(); 

        include_once __DIR__ . "/views/$view.php";

        $content = ob_get_clean(); // Clear the buffer

        // Use the layout according to the URL
        $current_url = $_SERVER['PATH_INFO'] ?? '/';

        if(str_contains($current_url, '/admin')) {
            include_once __DIR__ . '/views/admin-layout.php';
        } else {
            include_once __DIR__ . '/views/layout.php';
        }
    }
}