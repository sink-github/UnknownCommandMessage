<?php

namespace Sink\UnknownCommandMessage;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Loader extends PluginBase implements Listener {

    public function onEnable(): void{
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommandPreprocess(PlayerCommandPreprocessEvent $event): void{
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $bool = false;
        $exp = str_split($message);
        if($exp[0] === "/" || $exp[0] === "./") {
            array_shift($exp);
            foreach ($this->getServer()->getCommandMap()->getCommands() as $command) {
                if (strtolower($command->getName()) === implode("", $exp)) {
                    $bool = true;
                }
            }
            if (!$bool) {
                $message = TextFormat::colorize($this->getConfig()->getNested("messages.unknown-command", "&cThis command does not exist."));
                $message = str_replace(["{player}", "{cmd_name}"], [$player->getName(), implode("", $exp)], $message);
                $player->sendMessage($message);
                $event->cancel();
            }
        }
    }
}
