<?php

namespace orignx\utility\dependency_injection;

class Container
{
    private $bindings;
    private $singletons = [];

    public function __construct()
    {
        $this->bindings = new Service();
    }
    
    public function getResolvedClassName($class)
    {
        $bound = null;
        if ($this->bindings->has($class)) {
            $bound = $this->bindings->get($class);
        } else if (is_string($class) && class_exists($class)) {
            $bound = ['data' => $class];
        }     
        return $bound;
    }

    public function bind($type)
    {
        return $this->bindings->setActiveKey($type);
    }
    
    public function has($type) {
        return $this->bindings->has($type);
    }
        
    public function unbind($type)
    {
        $this->bindings->remove($type);
    }

    public function singleton($type, $arguments = [])
    {
        $resolvedClass = $this->getResolvedClassName($type)['data'];
        return $this->getSingletonInstance($type, $resolvedClass, $arguments);
    }
    
    private function getSingletonInstance($type, $class,  $arguments)
    {
        if (!isset($this->singletons[$type])) {
            $this->singletons[$type] = $this->getInstance($class, $arguments);
        }
        return $this->singletons[$type];        
    }
    
    public function resolve($type, $arguments = [])
    {
        if($type === null) {
            throw new \Exception("Cannot resolve an empty type");
        } 
        $resolvedClass = $this->getResolvedClassName($type);
        if ($resolvedClass['data'] === null) {
            throw new \Exception("Could not resolve dependency $type");
        }           
        if($resolvedClass['singleton'] ?? false) {
            return $this->getSingletonInstance($type, $resolvedClass['data'], $arguments);
        } else {
            return $this->getInstance($resolvedClass['data'], $arguments);
        }
    }
    
    private function getConstructorArguments($constructor, $arguments)
    {
        $argumentValues = [];
        $parameters = $constructor->getParameters();
        foreach ($parameters as $parameter) {
            $class = $parameter->getClass();
            $className = $class ? $class->getName() : null;
            if (isset($arguments[$parameter->getName()])) {
                $argumentValues[] = $arguments[$parameter->getName()];
            } else if($className == self::class){
                $argumentValues[] = $this;
            } else {                    
                $argumentValues[] = $className ? $this->resolve($className) : null;
            }
        }
        return $argumentValues;
    }

    public function getInstance($className, $arguments = [])
    {
        if (is_callable($className)) {
            return $className($this);
        } if(is_object($className)) {
            return $className;
        } 
        
        $reflection = new \ReflectionClass($className);
        if ($reflection->isInstantiable()) {
            throw new \Exception(
                "Class {$reflection->getName()} cannot be instantiated. Please provide a binding to an implementation."
            );
        }
        
        $constructor = $reflection->getConstructor();
        return $reflection->newInstanceArgs($constructor ? $this->getConstructorArguments($constructor, $arguments) : []);
    }
}
