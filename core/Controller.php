<?php
/**
 * Created by PhpStorm.
 * User: JhonErick
 * Date: 24/06/2018
 * Time: 19:18
 */
//namespace core;
use core\authenticate as authenticate;

class Controller extends authenticate\Authenticate
{
    public function __construct()
    {
        echo '__construct de Controller iniciado...';
        echo '<br>';
        echo $this->auth();
        echo '<br>';
    }

    public function teste()
    {
        echo 'teste<br>';
    }

}