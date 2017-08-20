<?php

class Container implements Countable, ArrayAccess
{
    private $type;
    protected $data;
    
    public function __construct($type)
    {
        $this->type =  $type;
    }
    
    public function getType($type)
    {
        $this->type;
    }
    
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }
    
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }
    
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }
    
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
    
    public function count()
    {
        ;
    }
}