<?php

namespace napthe\CMD;
use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use napthe\napthe;
use napthe\Card;
use napthe\BaokimTrans;
use pocketmine\utils\TextFormat;
		
class NapVipCommand extends PluginBase implements Listener{
	public function __construct(main $main, $name) {
 		parent::__construct(
 				$name, $main
 		);
 		$this->main = $main;
 		$this->setPermission("napvip.command");
 	}
 
 	public function Execute(CommandSender $sender, $currentAlias, array $args) {
 	
 		if (!isset($args[0])) {
 			if($sender->hasPermission('napvip.command')){
 				return true;
 			}
 			else{
 				$sender->sendMessage(TextFormat::RED."You do not have permission to use this command");
 				return true;
 			}
 		}
 		switch (strtolower($args[0])){
 			case'isset($args[1])':
 				if($this->mang($args[1])){
 						$this->activeMode($sender, $args(1));
 						
 					}else{
 						$sender->sendMessage(TextFormat::BLUE . "=====Help===");
 						$sender->sendMessage(TextFormat::GOLD . "/napvip <mobi|vittel|vina>");
 						$sender->sendMessage(TextFormat::GOLD . "/napxu <mobi|vittel|vina>");
 						$sender->sendMessage(TextFormat::BLUE . "/card top");
 					}
 				
 							
 				

 		}
	}
}
