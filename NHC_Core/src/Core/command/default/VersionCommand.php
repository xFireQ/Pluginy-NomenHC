<?php

namespace Core\command\default;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Core\util\ConfigUtil;
use pocketmine\lang\TranslationContainer;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class VersionCommand extends Command {
    public function __construct()
    {
        parent::__construct("version", "komenda version", true, ["about", "ver", "serwer"]);
    }

    public function execute(CommandSender $sender, String $label, array $args): void {
        if(count($args) === 0){
            $serwerName = $sender->getServer()->getName();
            $serwerApi = $sender->getServer()->getPocketMineVersion();
            $serwerVersion = $sender->getServer()->getVersion();
            $serwerProtocol = ProtocolInfo::CURRENT_PROTOCOL;

            $messages = ConfigUtil::getMessage("commands.ver.server");
            $messages = str_replace("{NAME}", $serwerName, $messages);
            $messages = str_replace("{API}", $serwerApi, $messages);
            $messages = str_replace("{VERSION}", $serwerVersion, $messages);
            $messages = str_replace("{PROTOCOL}", $serwerProtocol, $messages);


            foreach ($messages as $message) {
                $sender->sendMessage($message);
            }
        }else{
            $pluginName = implode(" ", $args);
            $exactPlugin = $sender->getServer()->getPluginManager()->getPlugin($pluginName);

            if($exactPlugin instanceof Plugin){
                $this->describeToSender($exactPlugin, $sender);

                return;
            }

            $found = false;
            $pluginName = strtolower($pluginName);
            foreach($sender->getServer()->getPluginManager()->getPlugins() as $plugin){
                if(stripos($plugin->getName(), $pluginName) !== false){
                    $this->describeToSender($plugin, $sender);
                    $found = true;
                }
            }

            if(!$found){
                $sender->sendMessage(new TranslationContainer("pocketmine.command.version.noSuchPlugin"));
            }
        }

    }

    private function describeToSender(Plugin $plugin, CommandSender $sender) : void{
        $desc = $plugin->getDescription();

        if(count($authors = $desc->getAuthors()) > 0){
            if(count($authors) === 1){
                $messages = ConfigUtil::getMessage("commands.ver.plugin");
                $messages = str_replace("{NAME}", $desc->getName(), $messages);
                $messages = str_replace("{VERSION}", $desc->getVersion(), $messages);
                $messages = str_replace("{AUTHOR}", "§9".implode("§8,§9 ", $authors), $messages);
                if($desc->getDescription() !== ""){
                    $messages = str_replace("{DESC}", $desc->getDescription(), $messages);
                } else {
                    $messages = str_replace("{DESC}", "BRAK", $messages);
                }

                if($desc->getWebsite() !== ""){
                    $messages = str_replace("{WEBSITE}", $desc->getWebsite(), $messages);
                } else {
                    $messages = str_replace("{DESC}", "BRAK", $messages);
                }
                foreach ($messages as $message) {
                    $sender->sendMessage($message);
                }
            }else{
                $messages = ConfigUtil::getMessage("commands.ver.plugin");
                $messages = str_replace("{NAME}", $desc->getName(), $messages);
                $messages = str_replace("{VERSION}", $desc->getVersion(), $messages);
                $messages = str_replace("{AUTHOR}", "§9".implode("§8,§9 ", $authors), $messages);

                if($desc->getDescription() !== ""){
                    $sender->sendMessage($desc->getDescription());
                    $messages = str_replace("{DESC}", $desc->getDescription(), $messages);
                } else {
                    $messages = str_replace("{DESC}", "BRAK", $messages);
                }

                if($desc->getWebsite() !== ""){
                    $messages = str_replace("{WEBSITE}", $desc->getWebsite(), $messages);
                } else {
                    $messages = str_replace("{DESC}", "BRAK", $messages);
                }

                foreach ($messages as $message) {
                    $sender->sendMessage($message);
                }            }
        }
    }
}