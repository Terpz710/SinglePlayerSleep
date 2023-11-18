<?php

declare(strict_types=1);

namespace DerphSZ\SinglePlayerSleep;

use pocketmine\player\Player;
use pocketmine\Server;

use pocketmine\event\player\PlayerBedEnterEvent;
use pocketmine\plugin\PluginBase;

use pocketmine\scheduler\Task;

use pocketmine\event\Listener;

class Main extends PluginBase implements Listener {
	
    public const TIME_DAY = 1000;
    public const TIME_NOON = 6000;
    public const TIME_SUNSET = 12000;
    public const TIME_NIGHT = 13000;
    public const TIME_MIDNIGHT = 18000;
    public const TIME_SUNRISE = 23000;

    public const TIME_FULL = 24000;
	
    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
	
    public function onEnterBed(PlayerBedEnterEvent $event) {
        $player = $event->getPlayer();
        $this->getScheduler()->scheduleDelayedTask(new SleepTask ($this, $player->getName()), 20 * 5);
    }

}

class SleepTask extends Task {
    public function __construct(Main $main, $player){
        $this->main = $main;
	$this->player = $player;
    }

    public function onRun(): void
    {
        $player = $this->main->getServer()->getPlayerExact($this->player);
        if($player->isSleeping()){
            $player->getWorld()->setTime(Main::TIME_SUNRISE);
            $player->stopSleep();
        }
    }

}
