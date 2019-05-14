<?php
include "./Model/TranslatedWord.php";
    class Tureng{

        const TR = "TR";
        const DE = "DE";
        const ES = "ES";
        const FR = "FR";

        const EnTrUrl = "https://tureng.com/tr/turkce-ingilizce/";
        const EnDeUrl = "https://tureng.com/tr/almanca-ingilizce/";
        const EnEsUrl = "https://tureng.com/tr/ispanyolca-ingilizce/";
        const EnFrUrl = "https://tureng.com/tr/fransizca-ingilizce/";

        private $mUrl;
        public function __construct($lang)
        {
            switch ($lang)
            {
                case $this::TR;
                    $this->mUrl = $this::EnTrUrl;
                    break;
                case $this::DE;
                    $this->mUrl = $this::EnDeUrl;
                    break;
                case $this::ES;
                    $this->mUrl = $this::EnEsUrl;
                    break;
                case $this::FR;
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

            if($return==false) {
                curl_close($ch);
                return false;
            }

            $html = new simple_html_dom();
            $html->load($return);

            $table = $html->find('.searchResultsTable',0);
            $means = [];

            $i =0;
            foreach ($table as $row)
            {
                /*echo 'mahmut'.$i.var_dump($row);
                $i++;*/
                //$child = $row->children(3);
                if(is_array($row) && is_object($row[3]))
                    array_push($means,$row[3]->children(3)->plaintext);
            }
/*
            $mean1 = $table->children(3)->children(3)->plaintext;
            $mean2 = $table->children(4)->children(3)->plaintext;
            $mean3 = $table->children(5)->children(3)->plaintext;
            if(is_object($table->children(8)->children(3)))
                $mean4 = $table->children(8)->children(3)->plaintext;
            else
                $mean4 = 'mahmut';

            array_push($means,$mean1,$mean2,$mean3,$mean4);*/
            if(!is_null($html->find('.tureng-voice',0)))
                $voice = 'http:'.$html->find('.tureng-voice',0)->first_child()->first_child()->src;
            else
                $voice = 'null';
            $translatedWord = new TranslatedWord($word,$means,$voice);

            curl_close($ch);
            return $translatedWord;
            //return $this->parse($word,$html);
        }

        private function parse($word,$content)
        {
            if (empty($content)) {
                return false;
            }

            $table = $content->find('.searchResultsTable',0);

            $mean1 = $table->children(3)->children(3)->outertext;
            $mean2 = $table->children(4)->children(3)->outertext;
            $mean3 = $table->children(5)->children(3)->outertext;
            $mean4 = $table->children(6)->children(3)->outertext;
            $voice = $content->find('.tureng-voice',0)->first_child()->first_child();

            $translatedWord = new TranslatedWord($word,$mean1,$mean2,$mean3,$mean4,$voice);
            return $translatedWord->toJson();
        }
    }