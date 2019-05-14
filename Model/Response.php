<?php
class Response implements JsonSerializable {
    private $result = "";
    private $error = NULL;
    private $data = NULL;
    /**
     * Response constructor.
     * @param string $result result for request
     * @param null $error null if success
     * @param null $data null if an error exist
     */
    public function __construct($result, $error, $data)
    {
        $this->result = $result;
        $this->error = $error;
        $this->data = $data;
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