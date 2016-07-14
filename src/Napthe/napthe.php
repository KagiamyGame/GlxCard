<?php

namespace napthe;

use napthe\BaokimTrans
use napthe\Card;
use napthe\LogFile;
use napthe\NMS\NMS;
use napthe\Result;
use napthe\TopLog;
use napthe\CMD\NapVipCommand;
use napthe\CMD\NapCoinCommand;

use pocketmine\Server;
use pocketmine\Player;
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
	public $baokim;
	public function onEnable(){
		@mkdir($this->getDataFolder());
		$this->fc = new Config($this->getDataFolder()."config.yml",Config::YAML);
		$this->saveDefaultConfig();
		$this->reloadConfig();
		
		$this->userbk = $this->getConfig()->get('CORE_API_HTTP_USR', '');
		$this->passbk = $this->getConfig()->get('CORE_API_HTTP_PWD', '');
		$this->api_username = $this->getConfig()->get('API_USERNAME', '');
		$this->api_password = $this->getConfig()->get('API_PASSWORD', '');
		$this->merchant_id = $this->getConfig()->get('MERCHANT_ID', '');
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		foreach ($this->$getServer()->getOnlinePlayer() as $p) {
		$c = new Card;
		$this->map->put($p->getUniqueId(), $c);
		}
		$this->log = LogFile::constructor__String("thedung");
		$this->logsai = LogFile::constructor__String("thesai");
		$this->topLog = TopLog::constructor__NapThe($this);
		
		$this->getCommand('napvip')->setExecutor(new NapVipCommand($this));
		
	}
	public function onDisable(){
			$this->log->close();
			$this->logsai->close();
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
			$e->setCancelled(true);
			$c->seri = $e->getMessage();
			$c->stage = 0;
			$p->sendMessage($this->getMessage("enteredSeri")->replace("{value}", $e->getMessage()));
			$this->napThe($p);
		}
		
	}
	public function BaokimTrans() {
		$this->fc = $this->getConfig();
		$this->baokim = BaokimTrans();
		
	}
}
