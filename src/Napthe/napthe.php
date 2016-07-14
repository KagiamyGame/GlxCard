<?php

namespace napthe;

use napthe\BaokimTrans;
use napthe\Card;
use napthe\Result;
use napthe\TopLog;
use napthe\CMD\NapVipCommand;
use napthe\CMD\NapCoinCommand;
use napthe\CMD\CardCommand;


use pocketmine\Server;
use pocketmine\plugin\PluginBase;
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
	private $saveTop;
	private $log;
	private $map;
	public function onEnable(){
	@mkdir($this->getDataFolder());
		$this->fc = new Config($this->getDataFolder()."config.yml",Config::YAML);
		$this->reloadConfig();
		$this->loadConfiguration();
		$this->initConfig();
		
		$this->userbk = $this->getConfig()->get('CORE_API_HTTP_USR', '');
		$this->passbk = $this->getConfig()->get('CORE_API_HTTP_PWD', '');
		$this->api_username = $this->getConfig()->get('API_USERNAME', '');
		$this->api_password = $this->getConfig()->get('API_PASSWORD', '');
		$this->merchant_id = $this->getConfig()->get('MERCHANT_ID', '');
		$this->secure_code = $this->getConfig()->get('SECURE_CODE', '');
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		foreach ($this->$getServer()->getOnlinePlayer() as $p) {
		$c = new Card;
		$this->map->put($p->getUniqueId(), $c);
		}
		$this->topLog = TopLog::constructor__NapThe($this);
		
		$this->getCommand('napvip')->setExecutor(new NapVipCommand($this));
		$this->getCommand('napxu')->setExecutor(new NapCoinCommand($this));
		$this->getCommand('card')->setExecutor(new CardCommand($this));
		
		$this->getCommand('napvip')->setExecutor(new NapVipCommand($this));
		$this->getCommand('napxu')->setExecutor(new NapCoinCommand($this));
		$this->getCommand('napthe')->setExecutor(new CardCommand($this));
		
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
	
	public function napThe($p) {
		$c = $this->map->get($p->UniqueId());
		$this->getServer()->getScheduler()->scheduleAsyncTask($this, new Runable());
	}
	
	protected function sendVip($p, $amount) {
		$cmd = $this->fc->get('Prize.' . '$amount\ 100');
		foreach ($cmd as $s) {
			$this->getServer()->dispatchCommand(new ConsoleCommandSender(),'setgroup '.$p->getName().' Vip2');
		}
	}
	
	public function activeMode($p, $mang) {
		$p->sendMessage($this->getMessage("seri"));
		$c = $this->map->get($p->UniqueId());
		$c->mang = $mang;
		$c->stage = 1;
	}
	
	public function getMessage($m) {
		return $this->fc->getString(("Message." .$m))->replace("&", "?");
	}
	
	public function loadConfiguration() {
		$this->getConfig()->setDefaults(true);
		$this->saveConfig();
		$this->getConfig()->setDefaults(false);
	}
	public function initConfig() {
		$this->fc = $this->getConfig();
		foreach ($this->fc->getAll(true) as $k) 
		$spl = $k->split("\\.");
		if ((((count($spl) /*from: spl.length*/ != 2) || $spl[0]->equals("Card")) || $this->fc->getEloolean[$k])) continue;
		$this->nhamang->add($spl[1]);
		$this->baokim = new BaokimTrans($userbk, $passbk, $api_username, $api_password, $secure_code, $merchant_id);
		$this->saveTop = $this->fc->get("Top.enable");
	}
}
