<?php
/**
 * Created by PhpStorm.
 * User: JhonErick
 * Date: 07/07/2018
 * Time: 15:49
 */

class ReturnData
{
    public $json = "";
    public function __construct($query, $parameters)
    {
        $this->json = $this->replacements($query, $parameters);
        //return '123';
    }

    public function replacements($query, $parameters)
    {
        if($_SERVER["CONTENT_TYPE"]=="application/x-www-form-urlencoded" && Request::method() == "PUT"){
            $put = file_get_contents('php://input');
            $put = explode("&", $put);
            foreach($put AS $value){
                $_PUT[explode("=", $value)[0]] = explode("=", $value)[1];
            }
        }elseif(Request::method() == "PUT"){
            return json_encode($this->bodyJson(0, "O content-type do envio precisa ser 'application/x-www-form-urlencoded' para requisição PUT!", []));
            die();
        }

        $getKeys = '`'.implode('`, `',array_keys($_GET)).'`';
        $getValues = "'".implode("', '",$_GET)."'";
        $postKeys = '`'.implode('`, `',array_keys($_POST)).'`';
        $postValues = "'".implode("', '",$_POST)."'";
        $putKeys = '`'.implode('`, `',array_keys($_PUT)).'`';
        $putValues = "'".implode("', '",$_PUT)."'";
        $isso = ['::get>keys', '::get>values','::post>keys', '::post>values','::put>keys', '::put>values'];
        $porIsso = [$getKeys, $getValues, $postKeys, $postValues, $putKeys, $putValues];
        $query = str_replace($isso, $porIsso, $query);

        foreach ($_GET AS $key => $value){
            $getUpdate[] = "`".$key."` = '".$value."'";
        }
        $getUpdate = implode(', ', $getUpdate);

        foreach ($_POST AS $key => $value){
            $postUpdate[] = "`".$key."` = '".$value."'";
        }

        foreach ($_PUT AS $key => $value){
            $putUpdate[] = "`".$key."` = '".$value."'";
        }
        $putUpdate = implode(', ', $putUpdate);
        $issoGet = ['::get','::post','::put'];
        $porIssoGet = [$getUpdate, $postUpdate, $putUpdate];
        $query = str_replace($issoGet, $porIssoGet, $query);

        foreach($_GET AS $key => $value){
            $thisGET[] = ':get>'.$key;
            $forThisGET[] = "'".$value."'"  ;
        }
        foreach($_POST AS $key => $value){
            $thisPOST[] = ':post>'.$key;
            $forThisPOST[] = "'".$value."'";
        }
        foreach($_PUT AS $key => $value){
            $thisPUT[] = ':put>'.$key;
            $forThisPUT[] = "'".$value."'";
        }

        foreach($parameters AS $key => $value){
            if($key != ":table"){
                $parameters[$key] = "'".$value."'";
            }else{
                $parameters[$key] = "`".$value."`";
            }
        }

        $query = str_replace($thisGET, $forThisGET, $query);
        $query = str_replace($thisPOST, $forThisPOST, $query);
        $query = str_replace($thisPUT, $forThisPUT, $query);
        $query = str_replace(["''", "``"], ["'", "`"], $query);

        $query = str_replace(array_keys($parameters), $parameters, $query);

        $query = urldecode($query);
        return $this->querySQLRoute($query);
    }

    private function querySQLRoute($query){
        $statement = new QueryBuilder(Connection::$pdo);
        $statement->query($query);

        if(preg_match('/insert/i', $query, $mat)){
            $list = ["lastId" => $statement->lastId()];
        }else{
            $list = $statement->list();
        }

        if($statement->status()){
            if($statement->count() > 0){
                return $this->returnJson(1,$list);
            }else{
                return $this->returnJson(2);
            }
        }else{
            return $this->returnJson(0,$statement->error());
        }
    }

    private function returnJson($status, $array = []){
        switch ($status){
            case 1:
                $json = $this->bodyJson('success', 'Query executada com sucesso!', $array);
             break;

             case 2:
                $json = $this->bodyJson('noData', 'Query executada com sucesso! Mas não houve nenhuma mudança de dados!(Casos: SELECT em um valor que foi apagado, query de UPDATE com valores que já estão atualizados ou tentar usar o DELETE em um registro que não existe mais)', $array);
             break;

             case 0:
                $json = $this->bodyJson('error', 'Erro na consulta vinculada a rota \''.Request::uri().'\'! Verifique os erros abaixo!', ["errors" => $array]);
             break;
        }
        return json_encode($json);
    }

    private function bodyJson($status, $msg, $data = []){
        return [
            "status"=> $status,
            "msg" => $msg,
            "data" => $data,
            "qtdData" => count($data)
        ];
    }
}