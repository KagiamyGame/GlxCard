<?php

namespace napthe;
use napthe\BaokimSCard;
use napthe\Card;
use napthe\LogFile;
use napthe\NMS\NMS;
use napthe\Result;
use napthe\TopLog;
use pocketmine\command\Command;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginManager;
use pocketmine\plugin\PluginDescription;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\HandlerList;
use pocketnine\scheduler\Task;

Class napthe extends Plugin implements Listener {
	public $fc;
	public function onEnable(){
		$this->saveDefaultConfig();
		$this->reloadConfig();
		
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		foreach ($Server->getOnlinePlayer() as $p) {
		$c = new Card;
		$this->map->put($p->getUniqueId(), $c);
		}
		$this->log = LogFile::constructor__String("thedung");
		$this->logsai = LogFile::constructor__String("thesai");
		$this->topLog = TopLog::constructor__NapThe($this);
		
	}
	public function onDisable(){
			$this->log->close();
			$this->logsai->close();
		}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		switch ($command->getName()){
		case"napthe" && isset ($args[0]):
			switch ($args[0]){
				case"":
				
			}
		}
	}
	public function onPlayerJoin(PlayerJoinEvent $e){
		$c = new Card();
		$this->map->put($e->getPlayer()->getUniqueId(), $c);
	}
	public  function PlayerChatEvent(PlayerChatEvent $e){
		$p = $e->getPlayer();
		$c = $this->map->get($p->getUniqueId());
		if (($c->stage == 1)){
			$e->setCancelled(true);
			$c->seri = $e->getMessage();
			$c->stage = 2;
			$p->sendMessage($this->getMessage("enteredSeri")->replace("{value}", $e->getMessage()));
			$p->sendMessage("pin");
		} else if (($c->stage == 2)){
			
		}
		
	}
}
