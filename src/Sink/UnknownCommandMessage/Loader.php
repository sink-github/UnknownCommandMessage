<?php

namespace Sink\UnknownCommandMessage;

use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\TextFormat;

class Loader extends PluginBase implements Listener {

    /** @var Command[] */
    protected array $commands;

    public function onEnable(): void{
        // setting its priority to be high by delaying initialization
        $this->saveDefaultConfig();
        $this->getScheduler()->scheduleDelayedTask(new ClosureTask(function (): void{
            $this->commands = $this->getServer()->getCommandMap()->getCommands();
        }), 30);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommandPreprocess(PlayerCommandPreprocessEvent $event): void{
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $bool = false;
        $exp = str_split($message);
        if($exp[0] === "/" || $exp[0] === "./") {
            array_shift($exp);
            foreach ($this->commands as $command) {
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