<?php
Router::get("produtos")->query('SELECT * FROM produtos');
Router::get("produtos/:id")->query('SELECT * FROM produtos WHERE id = :id');
Router::put("produtos/editar/:id")->query('UPDATE produtos SET ::put WHERE id = :id');
Router::delete('produtos/:id')->query('DELETE FROM produtos WHERE id = :id;');

Router::post('produtos/novo')->query("INSERT INTO produtos (nome, descricao, preco, imagem, marca) VALUES (:post>nome, :post>descricao, :post>preco, :post>imagem, :post>marca);");


//Router::get('exemploUrl')->controller('Class@method'); -- melhoria que poderia ser feita
//A APi receber um token, e somente efetuar queries em geral se o token for utilizado
/*

:id = url
:get>descricao = texto da descricao
:post>nome = nome
:put>id

::put = `nome` = 'nome que vai mudar', `descricao` = 'descricao'
::get
::post

*/


/*
Router::get("products")->query('SELECT * FROM produtos');
Router::get("products/:id")->query('SELECT * FROM produtos WHERE id = :id');
Router::delete("products/:id")->query('DELETE FROM produtos WHERE id = :id');
Router::put("products/:id")->query('UPDATE produtos SET ::put WHERE id = :id');
Router::get("products/test/:id")->query('SELECT * FROM produtos WHERE id = :id');
Router::get("products/teste/:id")->query('SELECT * FROM produtos WHERE id = :id');
Router::post("products/inserir")->query("INSERT INTO `produtos` );");
Router::post("products")->query('INSERT INTO produtos');
 */