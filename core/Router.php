<?php

//use controllers as controllers;

class Router
{
    public static $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public static $query = '';
    public static $method =    '';
    public static $uri =   '';

    public static function query($query)
    {
        self::$routes[self::$method][self::$uri] = $query;
    }

    public static function load($file)
    {
        $routes = new static;
        require $file;
        return $routes;
    }

    public static function get($uri)
    {
        self::$method = 'GET';
        self::$uri = $uri;
        self::$routes['GET'][$uri] = '';
        return new static;
    }

    public static function post($uri)
    {
        self::$method = 'POST';
        self::$uri = $uri;
        self::$routes['POST'][$uri] = '';
        return new static;
    }

    public static function put($uri)
    {
        self::$method = 'PUT';
        self::$uri = $uri;
        self::$routes['PUT'][$uri] = '';
        return new static;
    }

    public static function delete($uri)
    {
        self::$method = 'DELETE';
        self::$uri = $uri;
        self::$routes['DELETE'][$uri] = '';
        return new static;
    }

    private function callAction($query, $parameters = '')
    {
        $return = new ReturnData($query, $parameters);
    }

    public function direct($uri, $requestType)
    {
        if(array_key_exists($uri, self::$routes[$requestType]))
        {
            $query = self::$routes[$requestType][$uri];
            $this->callAction($query);
        }else{
            $this->uriParams($uri, $requestType);
        }
    }

    private function uriParams($uri, $requestType)
    {
        $uriArr = explode('/',$uri);

        /*percorre a variavel self::self::$routes[$requestType] em busca de uri que comecem com a primeiro valor de $uriArr e que contenha {indices}*/
        foreach(self::$routes[$requestType] AS $key => $value){
            if(preg_match('/^'.reset($uriArr).'\//',$key,$matches) &&
                preg_match('/:(.*)/',$key,$matches)){
                $routesParams[] = $key;
            }
        }
       // dd($routesParams);


        if(!isset($routesParams)){
            header('Content-Type: text/json');
            echo json_encode([
                'status' => 'error',
                'msg' => "Não existe a URI '{$uri}'"
            ]);
            die();
        }

        foreach($routesParams AS $value)
        {
            if(count($uriArr) === count(explode('/',$value))){
                $routes[] = $value;
            }
        }

        if(!isset($routes)){
            header('Content-Type: text/json');
            echo json_encode([
                'status' => 'error',
                'msg' => "Não existe a URI '{$uri}'"
            ]);
            die();
        }
        //dd($routes);
        $rotaUnica = [];
        if(count($routes) > 1){
            foreach($routes AS $key1 => $value){
                $route = explode('/', $value);
                foreach($route as $key => $piece){
                    if(!preg_match('/:(.*)/',$route[$key],$matchesPieces)){
                        if($route[$key] !== $uriArr[$key]){
                            unset($routes[array_search($value,$routes)]);
                        }
                    }
                }
            }
        }


        $routeArr = explode('/',end($routes));

        foreach ($routeArr as $key => $value) {
            if(!preg_match('/:(.*)/',$value,$matches))
            {
                $routesFixed[] = $routeArr[$key];
            }
        }

        foreach(explode('/',end($routes)) AS $key => $value){
            if(preg_match('/:(.*)/',$value,$matches))
            {
                $parameters[] = $uriArr[$key];
            }else{
                $uriFixed[] = $uriArr[$key];
            }
        }

        $diferencasUri = count(array_diff($routesFixed,$uriFixed));

        if($diferencasUri > 0){
            header('Content-Type: text/json');
            echo json_encode([
                'status' => 'error',
                'msg' => "Não existe a URI '{$uri}'"
            ]);
            die();
        }

        /*if(!in_array(self::uri(),self::self::$routes["allow_uri"]) && self::uri() != "home"){
            redirect("/home?msg=uriNotAllowed");
        }*/

        if(array_key_exists(end($routes), self::$routes[$requestType]))
        {
            $arr = explode('@',self::$routes[$requestType][end($routes)]);
            array_push($arr, $parameters);
            $this->callAction(...$arr);
        }



    }
}