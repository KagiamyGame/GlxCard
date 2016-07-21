<?php

namespace napthe\CMD;

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
  
  public function execute (CommandSender $sender, $currentAlias, array $args) {
  if($sender->hasPermission('card.command')){
    if (!isset($args[0])) {
      $sender->sendMessage("§e===> Lệnh Card <===");
      $sender->sendMessage("- §3/card để xem hướng dẫn về lệnh card!");
      $sender->sendMessage("- §e/card info để xem thẻ mà bạn đã nạp!");
      $sender->sendMessage("- &e/card top để xem top nạp thẻ trong server!");
      $sender->sendMessage("- §c/card reset để reset lịch sử nạp thẻ của bạn!")
    }
  }
  }
}
