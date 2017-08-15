<?php

class Text
{
    private $value;
    private $type;

    public function __construct($value, $type = null)
    {
        $this->value = $value;
        $this->type = $type ? $type : gettype($value);
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function  getType()
    {
        return $this->type;
    }
    
    public function isNumeric()
    {
        is_numeric($this->value) ? true : false;
    }
    
    public function isNull()
    {
        is_null($this->value) ? true : false;
    }
}