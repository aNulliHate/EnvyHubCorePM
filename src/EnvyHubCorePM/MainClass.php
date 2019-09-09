<?php

namespace EnvyHubCorePM;

use EnvyHubCorePM\listeners\PlayerEventListener;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\server\QueryRegenerateEvent;
use pocketmine\plugin\PluginBase;

class MainClass extends PluginBase implements Listener {

    public $hitSessions = [];

    public function onEnable() {
        //
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEventListener(), $this);

        $this->getScheduler()->scheduleRepeatingTask(new UpdaterTask($this), 5 * 20);


    }


    public function onQueryRegenerate(QueryRegenerateEvent $event) {
        $event->setMaxPlayerCount($event->getPlayerCount() + 1);
    }
}