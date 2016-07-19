<?php
namespace arrowtnt;

use pocketmine\entity\Arrow;
use pocketmine\entity\Entity;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\Listener;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\plugin\PluginBase;

Class Main extends PluginBase implements Listener
{
    Public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
    }

    Public function onHit(ProjectileHitEvent $event)
    {
        $arrow = $event->getEntity();
        if ($arrow instanceof Arrow) {
            $x = $arrow->getX();
            $y = $arrow->getY();
            $z = $arrow->getZ();
            $level = $arrow->getLevel();
            $chunk = $level->getChunk(round($x) >> 4, round($z) >> 4);
            $tnt = Entity::createEntity("PrimedTNT", $chunk, new CompoundTag("", [
                "Pos" => new ListTag("Pos", [
                    new DoubleTag("", $x),
                    new DoubleTag("", $y),
                    new DoubleTag("", $z)
                ]),//listtag pos
                "Motion" => new ListTag("Motion", [
                    new DoubleTag("", 0),
                    new DoubleTag("", 0),
                    new DoubleTag("", 0)
                ]), //listag motion
                "Rotation" => new ListTag("Rotation", [
                    new FloatTag("", lcg_value() * 360),
                    new FloatTag("", 0)
                ]), //listag rotation
            ])     //WHOLE COMPOUND TAG
        );//create entity
            $tnt->spawnToAll();
        }
    }
}