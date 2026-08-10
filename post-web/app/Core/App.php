<?php
    namespace App\Core;

    class App {
        protected $controller = "HomeController";
        protected $action = "index";
        protected $params = [];

        public function __construct() {
            $url = $this->parseUrl();

            if (isset($url[0]) && file_exists(ROOT_PATH . '/app/Controllers/' . ucfirst($url[0]) . 'Controller.php')) {
                $this->controller = ucfirst($url[0]) . 'Controller';
                unset($url[0]);
            }

            $controllerClass = "\\App\\Controllers\\" . $this->controller;
            
            if (class_exists($controllerClass)) {
                $this->controller = new $controllerClass;
            } else {
                die("Trang không tồn tại (Controller " . $controllerClass . " không tìm thấy)");
            }

            if (isset($url[1])) {
                if (method_exists($this->controller, $url[1])) {
                    $this->action = $url[1];
                    unset($url[1]);
                } else {
                    die("Hành động không tồn tại (Method " . $url[1] . " không tìm thấy)");
                }
            }

            $this->params = $url ? array_values($url) : [];

            call_user_func_array([$this->controller, $this->action], $this->params);
        }

        private function parseUrl() {
            if (isset($_GET['url'])) {
                return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
            }
            return [];
        }
    }
?>
