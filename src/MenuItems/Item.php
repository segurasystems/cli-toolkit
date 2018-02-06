<?php

namespace CLIToolkit\MenuItems;

class Item extends Base {
    /** @var string */
    protected $label;

    /** @var array */
    protected $flags = [];

    /** @var callable */
    protected $callback = null;

    public static function Factory($humanLabel, $callableFlags, $callback){
        $item = new self();
        $item->setLabel($humanLabel);
        $item->setFlags($callableFlags);
        $item->setCallback($callback);
        return $item;
    }

    public function setLabel(string $label){
        $this->label = $label;
        return $this;
    }

    public function setFlags($callableFlags){
        foreach(explode(" ", $callableFlags) as $flag){
            $this->flags[] = $flag;
        }
        return $this;
    }

    public function setCallback(callable $callback){
        $this->callback = $callback;
        return $this;
    }

    private function sort($a,$b){
        return strlen($a)-strlen($b);
    }

    public function getFlagString(){
        usort($this->flags,[$this,'sort']);

        return implode(", ", $this->flags);
    }

    public function getLabel(){
        return $this->label;
    }

    public function isFlag(string $flagNameToCheck) : bool{
        foreach($this->flags as $flag){
            if($this->stringMangle($flag) == $this->stringMangle($flagNameToCheck)){
                return true;
            }
        }
        return false;
    }

    private function stringMangle(string $string){
        return preg_replace("/[^[:alnum:][:space:]]/u", '', $string);
    }

    public function getCallback(){
        return $this->callback;
    }
}