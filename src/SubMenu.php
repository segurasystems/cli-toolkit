<?php

namespace Segura\CLI;

class SubMenu
{
    protected $name;
    protected $menuItem = [];

    /**
     * @param $name
     * @return SubMenu
     */
    static public function Create($name)
    {
        $submenu = new SubMenu();
        $submenu->setName($name);
        return $submenu;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return SubMenu
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}