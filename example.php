#!/usr/bin/php
<?php

require_once("vendor/autoload.php");

use \Segura\CLI;

$cli = new CLI\Toolkit();
$cli->addMenu(
    CLI\MenuItem::Create("time", "Time", function(){
        echo date("Y-m-d H:i:s")."\n";
    })
);

$cli->run();