<?php
/**
 * Created by PhpStorm.
 * User: JhonErick
 * Date: 24/06/2018
 * Time: 19:18
 */

namespace core\authenticate;

class Authenticate
{
    public function auth($status = true)
    {
        if($status){
            return 'autenticaçao necessária';
        }else{
            return 'visita permitida';
        }
    }
}