<?php

namespace EnvyHubCorePM;


use pocketmine\event\Listener;
use pocketmine\event\server\QueryRegenerateEvent;
use pocketmine\plugin\PluginBase;

class MainClass extends PluginBase implements Listener {

    public function onEnable() {
        //
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }


    public function onQueryRegenerate(QueryRegenerateEvent $event) {
        $event->setMaxPlayerCount($event->getPlayerCount() + 1);
    }

}