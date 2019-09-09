<?php
/**
 * Created by PhpStorm.
 * User: Clint Dave Luna
 * Date: 09/09/2019
 * Time: 2:42 AM
 */

namespace EnvyHubCorePM;


use pocketmine\scheduler\Task;
use slapper\entities\SlapperHuman;

class UpdaterTask extends Task {

    private $mainClass;

    public function __construct(MainClass $mainClass) {
        $this->mainClass = $mainClass;
    }

    public function onRun(int $currentTick) {
        $factionServerQuery = new ServerQuery("lenvymc.ml", 19133);
        $skyblockServerQuery = new ServerQuery("lenvymc.ml", 19134);

        $levels = $this->mainClass->getServer()->getLevels();
        foreach ($levels as $level) {
            $entities = $level->getEntities();
            foreach ($entities as $entity) {
                if ($entity instanceof SlapperHuman) {
                    $name = $entity->getNameTag();
                    if (strpos(strtolower($name), "faction") !== false && $factionServerQuery) {
                        $format = sprintf("§l§cFaction\n%s - %d/%d", $factionServerQuery ? "§aOnline" : "§cOffline", $factionServerQuery->getPlayersCount(), $factionServerQuery->getServerMaxPlayers());
                        $entity->setNameTag($format);
                    } else if (strpos(strtolower($name), "skyblock") !== false && $skyblockServerQuery) {
                        $format = sprintf("§l§eSkyBlock\n%s - %d/%d", $skyblockServerQuery ? "§aOnline" : "§cOffline", $skyblockServerQuery->getPlayersCount(), $skyblockServerQuery->getServerMaxPlayers());
                        $entity->setNameTag($format);
                    }
                }
            }
        }
    }

}