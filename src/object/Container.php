<?php

class Container implements Countable, ArrayAccess
{
    private $type;
    
    protected $data;
    protected $counter;
    
    public function __construct($type)
    {
        $this->type =  $type;
    }
    
    public function getType()
    {
        $this->type;
    }
    
    public function offsetSet($offset, $value)
    {
        if(!$this->offsetExists($offset)) {
            $this->counter += 1;
        }
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
        $this->counter -= 1;
    }
    
    public function count()
    {
        return $this->counter;
    }
}