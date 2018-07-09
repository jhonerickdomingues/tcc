<?php
Router::get("products")->query('SELECT * FROM produtos');
Router::get("products/:id")->query('SELECT * FROM produtos WHERE id = :id');
Router::put("products/editar/:id")->query('UPDATE produtos SET ::put WHERE id = :id');
Router::delete('products/:id')->query('DELETE FROM produtos WHERE id = :id;');
Router::post('products/new')->query("INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (:post>nome, :post>descricao, :post>preco, :post>imagem);");

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