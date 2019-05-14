<?php
include './Model/Response.php';
include './lib/simple_html_dom.php';
include "Tureng.php";

if(isset($_GET["word"]))
    {
        $tureng = new Tureng(Tureng::ES);
        //echo var_dump($tureng->translate($_GET["word"]));
        $result = $tureng->translate($_GET["word"]);
        echo json_encode($result,JSON_UNESCAPED_UNICODE );
        //echo var_dump($result);
    }
    else
    {
        $response = new Response("error","there is no parameter of word",null);
        echo $response->toJson();
    }
