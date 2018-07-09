<?php

/* CONEXÃO USADA É PDO */
return [
    'path' =>'/tcc',//deixe em branco caso seja a pasta raiz
    'database' => [
        'host' => 'localhost',
        'database' => 'teste',
        'user' => 'root',
        'password' =>'',
        'options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ]
    ]
];