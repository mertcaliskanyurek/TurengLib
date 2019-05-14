<?php
/**
 * Created by PhpStorm.
 * User: Mert
 * Date: 14/05/2019
 * Time: 12:08
 */

class TranslatedWord  implements JsonSerializable {
    private $word='';
    private $means=[];
    private $sound='';

    /**
     * TranslatedWord constructor.
     * @param string $word
     * @param array $means
     * @param string $sound
     */
    public function __construct($word, array $means, $sound)
    {
        $this->word = $word;
        $this->means = $means;
        $this->sound = $sound;
    }

    /**
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @return array
     */
    public function getMeans()
    {
        return $this->means;
    }

    /**
     * @return string
     */
    public function getSound()
    {
        return $this->sound;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
        return get_object_vars($this);
    }
}

