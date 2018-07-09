
<h1>Funcionamento do protótipo do gerador de API</h1>
<p>
  <h3>Funcionamento básico</h3>
  O funcionamento básico da api consiste em vincular uma Query que será executada no banco de dados configurado na API.
  
  <h4>Exemplos:</h4>
  <b>Router::get('produtos')->query('SELECT * FROM produtos');</b><br>
  <b>Router::get('produtos/:id')->query('SELECT * FROM produtos WHERE id = :id');</b> <i> o :id será subistituido pelo valor chamado na url. Exemplo: produtos/25 </i><br>
  <b>Router::post('produtos')->query('INSERT INTO produtos (nome, descricao, marca, preco, imagem) VALUES (:post>nome, :post>descricao, :post>marca, :post>preco, :post>imagem)')</b><br>
  <b>Router::put('produtos/:id')->query('UPDATE FROM produtos SET ::put WHERE id = :id');</b><br>
  <b>Router::delete('produtos/:id')->query('DELETE FROM produtos WHERE id = :id');</b><br>
 
</p>
