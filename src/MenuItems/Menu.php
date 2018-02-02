<?php

namespace CLIToolkit\MenuItems;

use CLIOpts\CLIOpts;
use CLIOpts\Values\ArgumentValues;

class Menu extends Base{
    protected $items;
    /**
     * @param Item[] $arrayOfItems
     */
    public static function Factory(array $arrayOfItems = [])
    {
        $menu = new self();
        foreach($arrayOfItems as $item) {
            $menu->addItem($item);
        }
        return $menu;
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    public function getFlags(){
        $flags = [];
        foreach($this->items as $item){
            if($item instanceof Item){
                $flags[$item->getFlagString()] = $item;
            }elseif($item instanceof Menu){
                $flags.= $item->getFlags();
            }
        }
        return $flags;
    }

    public function run(){
        $flags = $this->getFlags();

        $arguments = "Usage: {self} [options]\n";
        foreach($flags as $flag => $item){
            if($item instanceof Item) {
                $arguments .= "  {$flag} {$item->getLabel()}\n";
            }
        }
        $arguments.="  -h --help Show this help\n";
        $values = CLIOpts::run($arguments);
        foreach($values as $name => $value){
            \Kint::dump($name, $value);
        }

        if ($values->count()) {
            return $this->runNonInteractive($values);
        }else{
            return $this->runInteractive();
        }
    }

    public function runNonInteractive(ArgumentValues $values){

    }

    public function runInteractive(){

    }
}