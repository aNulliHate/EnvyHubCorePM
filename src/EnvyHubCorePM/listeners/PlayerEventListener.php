<?php

namespace EnvyHubCorePM\listeners;


use EnvyHubCorePM\MainClass;
use jojoe77777\FormAPI\ModalForm;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\Player;

class PlayerEventListener implements Listener {

	private $main;

    public function __construct(MainClass $main) {
    	$this->main = $main;
    }

    public function onPlayerJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $playerInventory = $player->getInventory();

        // initialize hub player
		$playerInventory->clearAll();
		$player->getLevel()->addSound(new AnvilUseSound($player));
		$player->teleport($this->main->getServer()->getDefaultLevel()->getSafeSpawn());

		// set lobby items
		$playerInventory->setItem(2, Item::get(347)->setCustomName("§eSwitch Server"));

        $welcomeForm = new ModalForm(function (Player $player, bool $data) {
        	if ($data) {
        		$player->sendMessage("enjoy!");
			} else {
        		$player->kick("hope you'll come back!", false);
			}
		});
        $welcomeForm->setTitle("§c§lWelcome to EnvyGames");
        $welcomeForm->setContent("by anullihate");
        $welcomeForm->setButton1("Play");
        $welcomeForm->setButton2("Leave");

		$player->sendForm($welcomeForm);
    }

    public function onPlayerInteract(PlayerInteractEvent $event) {
    	$item = $event->getItem();
    	$player = $event->getPlayer();
    	if ($item->hasCustomName()) {
    		if (strpos($item->getCustomName(), "Switch Server")) {
    			$switchServerForm = new SimpleForm(function(Player $player, $data) {
    				echo $data;
				});
    			$switchServerForm->setTitle("§eSwitch Server");
    			$switchServerForm->addButton("Faction");
    			$switchServerForm->addButton("SkyBlock");

    			$player->sendForm($switchServerForm);
			}
		}
	}
}
