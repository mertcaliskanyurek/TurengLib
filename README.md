# TurengLib
Php Tureng Library For Translate
Simple Php Tureng translate library

there is a example in index PHP
simple usage :

```
$lang = Tureng::EN_TR;
$inputLang = 'en';
$word = 'welcome';

$tureng = new Tureng($lang, $inputLang);
$result = $tureng->translate($word);

```
