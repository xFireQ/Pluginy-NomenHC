<?php

namespace Gildie\guild;

use NHC_Core\api\NameTagsAPI;
use Gildie\fakeinventory\SkarbiecInventory;
use pocketmine\block\Block;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\world\Position;
use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\tile\Chest as TileChest;
use pocketmine\player\Player;
use Gildie\Main;
use pocketmine\tile\Tile;

class Guild {

    private $lowerTag;
    private $db;
    private $battleTime = 0;
    private $skarbiecViewers = [];
    private $canSkarbiecTransaction = [];

    private $tag;
    private $name;
    private $leader;
    private $officer;
    private $lifes;
    private $expiryDate;
    private $conquerDate;
    private $players;
    private $alliances;
    private $heartPosition;
    private $heartPos;
    private $basePosition;
    private $plotSize;
    private $pvpGuild;
    private $pvpAlliances;

    public function __construct(string $tag) {
        $this->lowerTag = strtolower($tag);
        $this->db = Main::getInstance()->getDb();
        $this->guildInit();
    }

    private function guildInit() : void {
        $array = $this->db->query("SELECT * FROM guilds WHERE LOWER(guild) = '$this->lowerTag'")->fetchArray(SQLITE3_ASSOC);
        $this->tag = $array['guild'];
        $this->name = $array['name'];
        $this->leader = $this->db->query("SELECT * FROM players WHERE guild = '$this->tag' AND rank = 'Leader'")->fetchArray(SQLITE3_ASSOC)['player'];
       // $this->officer = $this->db->query("SELECT * FROM players WHERE guild = '$this->tag' AND rank = 'Officer'")->fetchArray(SQLITE3_ASSOC)['player'];
        $this->lifes = $array['lifes'];
        $this->expiryDate = $array['expiry_date'];
        $this->conquerDate = $array['conquer_date'];

        $players = [];

        $result = $this->db->query("SELECT * FROM players WHERE guild = '$this->tag'");

        while($row = $result->fetchArray(SQLITE3_ASSOC))
            $players[] = $row['player'];

        $this->players = $players;

        $alliances = [];

        $result = $this->db->query("SELECT * FROM alliances WHERE guild = '$this->tag'");

        while($row = $result->fetchArray(SQLITE3_ASSOC))
            $alliances[] = $row['alliance'];

        $this->alliances = $alliances;

        $this->heartPosition = new Vector3($array['heart_x'], $array['heart_y'], $array["heart_z"], Server::getInstance()->getWorldManager()->getDefaultWorld());
        $this->heartPos = new Position($array['heart_x'], $array['heart_y'], $array["heart_z"], Server::getInstance()->getWorldManager()->getDefaultWorld());
        $this->basePosition = new Vector3($array['base_x'], $array['base_y'], $array['base_z']);

        $this->plotSize = $this->db->query("SELECT * FROM plots WHERE guild = '$this->tag'")->fetchArray(SQLITE3_ASSOC)['size'];
        $this->pvpGuild = $array['pvp_guild'] == "on" ? true : false;
        $this->pvpAlliances = $array['pvp_alliances'] == "on" ? true : false;
    }

    public function getTag() : string {
        return $this->tag;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getLeader() : string {
        return $this->leader;
    }

    public function setLeader(string $player) : void {
        $this->leader = $player;
    }

    public function getOfficer() : ?string {
        return $this->officer;
    }

    public function setOfficer(string $player) : void {
        $this->officer = $player;
    }

    public function getLifes() : int {
        return $this->lifes;
    }

    public function setLifes(int $lifes) : void {
        $this->db->query("UPDATE guilds SET lifes = '$lifes' WHERE guild = '$this->tag'");
        $this->lifes = $lifes;
    }

    public function getExpiryDate() : string {
        return $this->expiryDate;
    }

    public function setExpiryDate(string $date) : void {
        $this->db->query("UPDATE guilds SET expiry_date = '$date' WHERE guild = '$this->tag'");
        $this->expiryDate = $date;
    }

    public function getConquerDate() : string {
        return $this->conquerDate;
    }

    public function setConquerDate(string $date) : void {
        $this->db->query("UPDATE guilds SET conquer_date = '$date' WHERE guild = '$date'");
        $this->conquerDate = $date;
    }

    public function canConquer() : bool {
        return time() > strtotime($this->getConquerDate());
    }

    public function getBattleTime() : int {
        return $this->battleTime;
    }

    public function setBattleTime() : void {
        $this->battleTime = time();
    }

    public function getPlayers() : array {
        return $this->players;
    }

    /**
     * @return mixed
     */
    public function getHeartPos() : Position {
        return $this->heartPos;
    }

    public function isPlayerInGuild(string $player) : bool {
        return in_array($player, $this->players);
    }

    public function getMembersCount() : int {
        return count($this->getPlayers());
    }

    public function getPoints() : int {
        

        $points = 0;

        foreach($this->getPlayers() as $nick)
        $api = Server::getInstance()->getPluginManager()->getPlugin("NHC_Core");
            $points += (int) $api->getPoints($nick);
            

        if($points == 0)
            return $points;

        return floor($points / $this->getMembersCount());
    }

    public function getRankPlace() : int {
        foreach(Main::getInstance()->getGuildManager()->getGuildsTop() as $place => $guild)
            if(strtolower($guild->getTag()) == $this->lowerTag)
                return $place;


        return -1;
    }

    public function getAlliances() : array {
        return $this->alliances;
    }

    public function getPlayerRank(string $player) : string {
        $array = $this->db->query("SELECT * FROM players where player = '$player'")->fetchArray(SQLITE3_ASSOC);

        return $array['rank'];
    }

    public function setPlayerRank(string $player, string $rank) : void {
        if($this->getPlayerRank($player) == "Officer")
            $this->officer = null;

        $this->db->query("UPDATE players SET rank = '$rank' WHERE player = '$player'");
        if($rank == "Leader")
            $this->setLeader($player);
        elseif($rank == "Officer")
            $this->setOfficer($player);
    }

    public function addPlayer(string $player, string $rank = "Member") : void {
        $this->db->query("INSERT INTO players (player, guild, rank) VALUES ('$player', '$this->tag', '$rank')");
        Main::getInstance()->getGuildManager()->setDefaultPermissions($player);
        Main::getInstance()->getGuildManager()->updateNameTags();
        $this->players[] = $player;
    }

    public function removePlayer(string $nick) : void {
         $this->db->query("DELETE FROM players WHERE player = '$nick' AND guild = '$this->tag'");
        Main::getInstance()->getGuildManager()->removeAllPermissions($nick);

        $player = Server::getInstance()->getPlayerExact($nick);

        if($player != null)
            //NameTagsAPI::setNameTag($player);

        Main::getInstance()->getGuildManager()->updateNameTags();
        unset($this->players[array_search($nick, $this->players)]);
        Main::getInstance()->getGuildManager()->unsetPlayerGuild($nick);
    }

    public function getHeartPosition() : Vector3 {
        return $this->heartPosition;
    }

    public function remove(Level $level) : void {

        Main::getInstance()->getGuildManager()->unsetGuild($this->getTag());
        Main::getInstance()->getGuildManager()->updateNameTags();

        $level->setBlock($this->getHeartPosition(), BlockFactory::getInstance()->get(0));
        $chestPos = $this->getHeartPosition();
        $chest = $level->getBlock($chestPos);

        $tile = Tile::createTile(Tile::CHEST, $level, TileChest::createNBT($chestPos));
        $tile = $level->getTile($chestPos);

        foreach($this->getPlayers() as $nick)
            $this->removePlayer($nick);

        $this->db->query("DELETE FROM plots WHERE guild = '$this->tag'");
        $this->db->query("DELETE FROM alliances WHERE guild = '$this->tag'");
        foreach($this->getAlliances() as $tag)
            Main::getInstance()->getGuildManager()->getGuildByTag($tag)->removeAllianceWith($this);

        //$this->db->query("DELETE FROM alliances WHERE alliance = '$this->tag'");
        $this->db->query("DELETE FROM guilds WHERE guild = '$this->tag'");
    }

    public function setBase(Vector3 $pos) : void {
         $this->db->query("UPDATE guilds SET (base_x, base_y, base_z) = ('{$pos->getX()}', '{$pos->getY()}', '{$pos->getZ()}') WHERE guild = '$this->tag'");
         $this->basePosition = $pos;
         return;
    }

    public function getBase() : Vector3 {
        return $this->basePosition;
    }

    public function getPlotSize() : int {
        return $this->plotSize;
    }

    public function getMaxPlotSize() : int {
        return 80;
    }

    public function addPlotSize(int $add) {
        $size = $this->plotSize + $add;

        $arm = floor($size / 2);

        $x = $this->getHeartPosition()->getPosition()->getFloorX();
        $z = $this->getHeartPosition()->getPosition()->getFloorZ();

        $x1 = $x + $arm;
        $z1 = $z + $arm;
        $x2 = $x - $arm;
        $z2 = $z - $arm;

        $this->db->query("UPDATE plots SET (size, x1, z1, x2, z2) = ('$size', '$x1', '$z1', '$x2', '$z2') WHERE guild = '$this->tag'");
        $this->plotSize += $size;
    }


    public function hasAllianceWith(Guild $guild) : bool {
        return in_array($guild->getTag(), $this->alliances);
    }

    public function setAllianceWith(Guild $guild) : void {
        $this->db->query("INSERT INTO alliances (guild, alliance) VALUES ('$this->tag', '{$guild->getTag()}')");
        $this->alliances[] = $guild->getTag();
    }

    public function removeAllianceWith(Guild $guild) : void {
        $this->db->query("DELETE FROM alliances WHERE guild = '$this->tag' AND alliance = '{$guild->getTag()}'");
        unset($this->alliances[array_search($guild->getTag(), $this->players)]);
    }

    public function isGuildPvP() : bool {
        return $this->pvpGuild;
    }

    public function setGuildPvP(bool $status) : void {
        $this->pvpGuild = $status;
        $status = $status ? "on" : "off";

        $this->db->query("UPDATE guilds SET pvp_guild = '$status' WHERE guild = '$this->tag'");
    }

    public function isAlliancesPvP() : bool {
        return $this->pvpAlliances;
    }

    public function setAlliancesPvP(bool $status) : void {
        $this->pvpAlliances = $status;
        $status = $status ? "on" : "off";

        $this->db->query("UPDATE guilds SET pvp_alliances = '$status' WHERE guild = '$this->tag'");
    }

    public function messageToMembers(string $message) {
        foreach($this->getPlayers() as $nick) {
            $player = Server::getInstance()->getPlayer($nick);

            if($player !== null)
                $player->sendMessage($message);
        }
    }
   
}