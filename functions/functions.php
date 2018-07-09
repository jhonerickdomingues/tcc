<?php

function dd($valor  )
{
    echo "<pre>";
    var_dump($valor );
    echo "</pre>";
    die();
}

function redirect($uri)
{
    header("Location: ".$uri);
}

function view($view, $parameters = [])
{
    extract($parameters);
    $file = "views/".$view.".view.php";
    if(is_file($file)){
        mergePieces($file);
    }
}

function includePiece($file){
    require "views/includesDefault/$file.piece.php";
}

function route($uri){
    global $app;
    $path = '';
    if(!empty($app["path"])){
        $path = $app["path"];
    }
    return $path.$uri;
}

function mergePieces($file)
{
    global $app;
    if(in_array(Request::uri(), $app["notIncludeDefaultPieces"]))
    {
        includePiece("head");
        require $file;
        includePiece("footer");
    }else{
        includePiece("head");
        includePiece("header");
        includePiece("nav");
        require $file;
        includePiece("footer");
    }
}