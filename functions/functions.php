<?php

function dd($valor)
{
    echo "<pre>";
    var_dump($valor );
    echo "</pre>";
    die();
}

function view($view, $data = []){
    extract($data);
    require "views/$view.view.php";
}