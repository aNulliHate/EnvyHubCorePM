<?php

namespace EnvyHubCorePM\listeners;


use EnvyHubCorePM\MainClass;
use pocketmine\event\Listener;

class PlayerEventListener implements Listener {

	private $main;

    public function __construct(MainClass $main) {
    	$this->main = $main;
    }


}
