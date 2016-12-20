<?php

namespace Segura\CLI;

class MenuItem
{
    protected $command;
    protected $actionName;
    protected $actionDescription;
    protected $callback;

    public function __construct(string $command, string $actionName, callable $callback = null)
    {
        $this
            ->setCommand($command)
            ->setActionName($actionName)
            ->setCallback($callback);
    }

    public static function Create(string $command, string $actionName, callable $callback = null)
    {
        return new self($command, $actionName, $callback);
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $command
     * @return MenuItem
     */
    public function setCommand($command)
    {
        $this->command = $command;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @param mixed $actionName
     * @return MenuItem
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionDescription()
    {
        return $this->actionDescription;
    }

    /**
     * @param mixed $actionDescription
     * @return MenuItem
     */
    public function setActionDescription($actionDescription)
    {
        $this->actionDescription = $actionDescription;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param mixed $callback
     * @return MenuItem
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }
}
