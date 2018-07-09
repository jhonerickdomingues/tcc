<?php

//ob_start("ob_gzhandler");
require 'core/bootstrap.php';

Connection::make($app['database']);

$router = Router::load('routes.php');

$router->direct(Request::uri(), Request::method());

//ob_end_flush();