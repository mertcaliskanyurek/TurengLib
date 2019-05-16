<?php
include "./Model/TranslatedWord.php";
    class Tureng{

        const EN_TR = "en-tr";
        const EN_DE = "en-de";
        const EN_ES = "en-es";
        const EN_FR = "en-fr";

        const EnTrUrl = "https://tureng.com/tr/turkce-ingilizce/";
        const EnDeUrl = "https://tureng.com/tr/almanca-ingilizce/";
        const EnEsUrl = "https://tureng.com/tr/ispanyolca-ingilizce/";
        const EnFrUrl = "https://tureng.com/tr/fransizca-ingilizce/";

        private $mUrl;
        private $inputLang;
        public function __construct($lang, $inputLang)
        {
            $this->inputLang = $inputLang;

            switch ($lang)
            {
                case $this::EN_TR;
                    $this->mUrl = $this::EnTrUrl;
                    break;
                case $this::EN_DE;
                    $this->mUrl = $this::EnDeUrl;
                    break;
                case $this::EN_ES;
                    $this->mUrl = $this::EnEsUrl;
                    break;
                case $this::EN_FR;
                    $this->mUrl = $this::EnFrUrl;
                    break;
            }
        }

        public function translate($word)
        {
            $this->mUrl .= $word;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->mUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $return = curl_exec($ch);
            curl_close($ch);

            if($return==false) {
                return false;
            }

            $html = new simple_html_dom();
            $html->load($return);

            return $this->parse($word,$html);
        }

        private function parse($word,$content)
        {
            $means = [];

            if($this->inputLang == 'en')
                $table = $content->find('td[class="tr ts"]');
            else
                $table = $content->find('td[class="en tm"]');

            foreach ($table as $row)
            {
                if(strpos($row->plaintext,$word) === false){
                    array_push($means,$row->plaintext);
                }
            }

            if(!is_null($content->find('.tureng-voice',0)))
                $voice = 'http:'.$content->find('.tureng-voice',0)->first_child()->first_child()->src;
            else
                $voice = 'null';
            return new TranslatedWord($word,$means,$voice);
        }
    }