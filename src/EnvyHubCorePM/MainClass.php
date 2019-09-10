<?php

namespace EnvyHubCorePM;

use EnvyHubCorePM\listeners\PlayerEventListener;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\server\QueryRegenerateEvent;
use pocketmine\plugin\PluginBase;
use slapper\entities\SlapperHuman;

class MainClass extends PluginBase implements Listener {

    public $hitSessions = [];

    public function onEnable() {
        //
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEventListener(), $this);

//        $this->getScheduler()->scheduleRepeatingTask(new UpdaterTask($this), 5 * 20);


    }


    public function onQueryRegenerate(QueryRegenerateEvent $event) {
        $factionServerQuery = new ServerQuery("play.lenvymc.ml", 19133);
        $skyblockServerQuery = new ServerQuery("play.lenvymc.ml", 19134);

        $level = $this->getServer()->getLevelByName("hubhub");
        if ($level !== null) {
            $factionSlapperEntity = $level->getEntity(6);
            $skyblockSlapperEntity = $level->getEntity(4);

            if ($factionSlapperEntity !== null && $factionServerQuery->status() == "online") {
                $name = $factionSlapperEntity->getNameTag();
                $format = sprintf("§l§cFaction\n%s - %d/%d", $factionServerQuery->getAll()['server_wl'] == "on" ? "§eWhitelisted" : "§aOnline", $factionServerQuery->getPlayersCount(), $factionServerQuery->getServerMaxPlayers());
                $factionSlapperEntity->setNameTag($format);
            }
            if ($skyblockSlapperEntity !== null && $skyblockServerQuery->status() == "online") {
                $name = $skyblockSlapperEntity->getNameTag();
                $format = sprintf("§l§bSkyBlock\n%s - %d/%d", $skyblockServerQuery->getAll()['server_wl'] == "on" ? "§eWhitelisted" : "§aOnline", $skyblockServerQuery->getPlayersCount(), $skyblockServerQuery->getServerMaxPlayers());
                $skyblockSlapperEntity->setNameTag($format);
            }
        }
        $allServersPlayerCount = $event->getPlayerCount() + (int)$factionServerQuery->getPlayersCount() + (int)$skyblockServerQuery->getPlayersCount();
        $event->setPlayerCount($allServersPlayerCount);
        $event->setMaxPlayerCount($allServersPlayerCount + 1);
    }
}