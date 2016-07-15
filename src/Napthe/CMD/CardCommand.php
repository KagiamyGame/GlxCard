<?php

namespace napthe;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use napthe/napthe;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class CardCommand extends PluginCommand {
  private $plugin;
  public function __construct(Napthe $plugin, $name) {
    parent::__construct(
      $name, $plugin
    );
    $this->plugin = $plugin;
    $this->setPermission("card.command");
    $this->setAliases(array("card"));
  }
}
