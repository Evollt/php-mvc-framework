<?php

namespace app\core;


class Router
{
    public Request $request;
    protected array $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;
        // Проверка на то существует ли такая страница у нас в роутинге
        if($callback === false) {
            return 'Not Found';
        }

        // Проверка на вывод view шаблона
        if(is_string($callback)) {
            return $this->renderView($callback);
        }

        echo call_user_func($callback);
    }

    public function renderView($view)
    {
        include_once __DIR__."/../views/$view.php";
    }
}