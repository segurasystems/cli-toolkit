<?php

namespace Segura\CLI;

use Garden\Cli\Cli as CliBuilder;
use PhpSchool\CliMenu\CliMenu;
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

    static public function Factory()
    {
        return new self();
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
        if ($guiMode) {
            echo "GUI MODE ENABLED\n";
        } else {
            echo "GUI MODE DISABLED\n";
        }
        return $this;
    }

    public function addMenu(MenuItem $menuItem)
    {
        $this->menuItems[] = $menuItem;
        return $this;
    }

    protected function decideMode()
    {
        global $argv;
        if (count($argv) > 1) {
            $this->setGuiMode(false);
        } else {
            $this->setGuiMode(true);
        }
    }

    public function run()
    {
        $this->decideMode();

        if ($this->isGuiMode()) {
            $this->runGui();
        } else {
            $this->runCli();
        }
        return true;
    }

    protected function runGui()
    {
        foreach ($this->menuItems as $menuItem) {
            /** @var $menuItem MenuItem */
            $this->guiMenu->addItem($menuItem->getActionName(), function (CliMenu $menu) use ($menuItem) {
                $callback = $menuItem->getCallback();
                $callback();
                self::waitForKeypress();
                $menu->redraw();
            });
        }
        $this
            ->guiMenu
            ->build()
            ->open();
    }

    protected function runCli()
    {
        global $argv;
        foreach ($this->menuItems as $menuItem) {
            /** @var $menuItem MenuItem */
            $this->cliMenu->command($menuItem->getCommand(), $menuItem->getActionDescription());
        }
        $args = $this->cliMenu->parse($argv, true);

        foreach ($this->menuItems as $menuItem) {
            /** @var $menuItem MenuItem */
            if ($args->getCommand() == $menuItem->getCommand()) {
                $callback = $menuItem->getCallback();
                $callback();
            }
        }
    }

    public static function waitForKeypress($waitMessage = "Press ENTER key to continue.")
    {
        echo "\n{$waitMessage}\n";
        return trim(fgets(fopen('php://stdin', 'r')));
    }
}
