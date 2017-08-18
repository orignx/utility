<?php

class Container implements Countable, ArrayAccess
{
    private $type;
    
    public function __construct($type)
    {
        $this->type =  $type;
    }

    public function offsetSet($offset, $value)
    {
        ;
    }
    
    public function offsetGet($offset, $value)
    {
        ;
    }
    public function offsetExists($offset, $value)
    {
        ;
    }
    
    public function offsetUnset($offset, $value)
    {
        ;
    }
    
    public function count()
    {
        ;
    }
}