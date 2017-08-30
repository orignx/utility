<?php

namespace orignx\utility\dependency_injection;

class Service
{
    private $data;
    private $active;
    
    public function setActiveKey($key)
    {
        $this->active = $key;
        return $this;
    }

    public function to($value)
    {
        $this->data[$this->active] = ['data' => $value];
        return $this;
    }

    public function get($key)
    {
        return $this->data[$key];
    }

    public function has($key)
    {
        return isset($this->data[$key]);
    }
    
    public function remove($type)
    {
        unset($this->data[$type]);
    }
    
    public function asSingleton()
    {
        $this->data[$this->active]['singleton'] = true;
    }
}