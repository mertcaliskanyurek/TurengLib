# TurengLib
Php Tureng Library For Translate
Simple Php Tureng translate library

there is a example in index PHP
simple usage :

```
$lang = Tureng::EN_TR;
$inputLang = 'en';
$word = 'animal';

$tureng = new Tureng($lang, $inputLang);
$result = $tureng->translate($word);

```
Result:

```
{
word: "animal",
means: [
"hayvan",
"hayvan",
"hayvani",
"hayvansal",
"hayvanca",
...
],
sound: "http://voices.tureng.co/TR/AmE/3d/3d5905e9-1eb5-4cd7-acdb-61d5532ece14.mp3"
}

```
There is a simple rest api in index.php with Tureng library
