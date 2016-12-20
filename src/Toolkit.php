<?php

namespace Segura\CLI;

use Garden\Cli\Cli as CliBuilder;
use PhpSchool\CliMenu\CliMenuBuilder as GuiBuilder;

class Toolkit
{

    protected $menuItems = [];

    /** @var GuiBuilder */
    protected $guiMenu;

    /** @var CliBuilder */
    protected $cliMenu;

    /** @var bool Whether or not we're going to render a GUI, or be a CLI application */
    protected $guiMode = true;

    public function __construct()
    {
        $this->guiMenu = new GuiBuilder();
        $this->cliMenu = new CliBuilder();
    }

    /**
     * @return array
     */
    public function getMenuItems(): array
    {
        return $this->menuItems;
    }

    /**
     * @param array $menuItems
     * @return Toolkit
     */
    public function setMenuItems(array $menuItems): Toolkit
    {
        $this->menuItems = $menuItems;
        return $this;
    }

    /**
     * @return GuiBuilder
     */
    public function getGuiMenu(): GuiBuilder
    {
        return $this->guiMenu;
    }

    /**
     * @param GuiBuilder $guiMenu
     * @return Toolkit
     */
    public function setGuiMenu(GuiBuilder $guiMenu): Toolkit
    {
        $this->guiMenu = $guiMenu;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isGuiMode(): bool
    {
        return $this->guiMode;
    }

    /**
     * @param boolean $guiMode
     * @return Toolkit
     */
    public function setGuiMode(bool $guiMode): Toolkit
    {
        $this->guiMode = $guiMode;
        return $this;
    }

    public function addMenu(MenuItem $menuItem)
    {
        $this->menuItems[] = $menuItem;
    }

    protected function decideMode(){

    }

    public function run()
    {
        $this->decideMode();

        if($this->isGuiMode()) {
            $this->runGui();
        }else{
            $this->runCli();
        }
        return true;
    }

    protected function runGui()
    {
        foreach ($this->menuItems as $menuItem) {
            /** @var $menuItem MenuItem */
            $this->guiMenu->addItem($menuItem->getActionName(), $menuItem->getCallback());
        }
        $this
            ->guiMenu
            ->build()
            ->open();
    }

    protected function runCli()
    {
        foreach($this->menuItems as $menuItem){
            $this->cliMenu->command()
        }
    }
}