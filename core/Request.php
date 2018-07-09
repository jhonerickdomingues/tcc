<?php
/**
 * Created by PhpStorm.
 * User: JhonErick
 * Date: 12/06/2018
 * Time: 08:23
 */

class Request
{
    public static function uri(){
        global $app;
        $uri =  parse_url($_SERVER['REQUEST_URI']);
        //echo $uri['path'].'<br>';
        $uri['path'] = trim($uri['path'],$app['path']);
        //echo $uri['path'].'<br>';
        return trim($uri['path'],'/');
    }

    public static function method(){
        return $_SERVER['REQUEST_METHOD'];
    }
}