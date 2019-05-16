<?php
include './Model/Response.php';
include './lib/simple_html_dom.php';
include "Tureng.php";

    if(isset($_GET["lang"]) && isset($_GET["input_lang"]) && isset($_GET["word"]))
    {
        $lang = $_GET["lang"];
        if($lang != Tureng::EN_TR && $lang != Tureng::EN_DE
                    && $lang != Tureng::EN_ES && $lang != Tureng::EN_FR)
        {
            $errorMsg = 'bad request, lang parameter must be one of :'.Tureng::EN_TR.','
                .Tureng::EN_FR.','.Tureng::EN_ES.','.Tureng::EN_DE;
            print_response(new Response("error",$errorMsg,null));
        }
        else
        {
            $tureng = new Tureng($_GET["lang"],$_GET["input_lang"]);
            if($result = $tureng->translate($_GET["word"]))
                print_response(new Response("OK",null,$result));
            else
                print_response(new Response("error","connection error",null));
        }
    }
    else
    {
        $response = new Response("error","bad request, missing parameter(s) [lang,input_lang,word]",null);
        print_response($response);
    }

    function print_response($response)
    {
        echo json_encode($response,JSON_UNESCAPED_UNICODE);
    }