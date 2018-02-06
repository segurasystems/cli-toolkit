<?php

namespace CLIToolkit\MenuItems;

use CLIOpts\CLIOpts;
use CLIOpts\Values\ArgumentValues;

class Menu extends Base{
    /** @var Item[] */
    protected $items = [];

    protected $cliOpts = [];

    /** @var ArgumentValues */
    private $argumentValues;

    /**
     * @param Item[] $arrayOfItems
     * @return Menu
     */
    public static function Factory(array $arrayOfItems = [])
    {
        $menu = new self();
        foreach($arrayOfItems as $item) {
            $menu->addItem($item);
        }
        return $menu;
    }

    /**
     * @param Item $item
     * @return $this
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param $flag
     * @param $name
     * @return $this
     */
    public function addOptionalCliParam($flag, $name){
        $this->cliOpts[$flag] = $name;
        return $this;
    }

    /**
     * @return string[]
     */
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

        if(count($this->cliOpts) > 0) {
            $arguments.= "\n\n";

            foreach ($this->cliOpts as $flag => $description) {
                $arguments.= "  {$flag} {$description}\n";
            }
        }

        $arguments.= "\n";

        $this->argumentValues  = CLIOpts::run($arguments);

        if ($this->argumentValues->count()) {
            return $this->runNonInteractive();
        }else{
            return $this->runInteractive();
        }
    }

    public function runNonInteractive(){
        foreach($this->getArgumentValues() as $name => $value){
            foreach($this->items as $item){
                if($item->isFlag($name)){
                    $callback = $item->getCallback();
                    $callback($this);
                }
            }
        }
    }


    public function runInteractive(){

    }

    public function getArgumentValues(){
        return $this->argumentValues;
    }
}