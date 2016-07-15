<?php

namespace napthe;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use napthe/napthe;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class CardCommand extends PluginCommand {
  
  public function __construct(main $main, $name) {
    parent::__construct(
      $name, $main
    );
    $this->main = $main;
    $this->setPermission("card.command");
    $this->setAliases(array("card"));
  }
}
