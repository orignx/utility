<?php

namespace orignx\utility\object;

class Container extends \ArrayObject
{
    private $type;
    
    public $data;
    protected $counter;
    
    public function __construct($type)
    {
        $this->type =  $type;
        $this->data = [];
    }
    
    public function getType()
    {
        $this->type;
    }
}