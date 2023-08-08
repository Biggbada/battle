<?php
class Player
{
    public int $id;
    public int $initial_mana;
    public int $initial_health;
    public int $initial_pow;
    public ?string $name;
    public ?float $power;
    public ?float $mana;
    public ?float $health;
    public ?string $comment;

    public function __construct(string $name = null, float $power = null, float $mana = null, float $health = null)
    {
        $this->name = $this->name ?? $name;
        $this->power = $this->initial_pow ?? $power;
        $this->mana = $this->initial_mana ?? $mana;
        $this->health = $this->initial_health ?? $health;
    }
    public function attack(Player $player)
    {
        $damage = ($this->power / 10) * rand(1, 3);
        $player->health -= $damage;
        if ($player->health < 0) {
            $player->health = 0;
        }
        $this->comment = "$this->name attaque $player->name et lui inflige $damage de degats";
        // $damage = $player->power / 20;
        // $this->health -= $damage;
        // echo "  $player->name réplique et inflige $damage de dégat à $this->name.";
    }


    public function cure()
    {
        if ($this->mana > 0) {
            $healthGain = ($this->mana / 20) + 10;
            $this->health += $healthGain;
            $usedMana = ($this->mana * 0.75) + 1;
            $this->mana -= $usedMana;
            if ($this->health > 100) {
                $this->health = 100;
            }
            if ($this->mana < 0) {
                $this->mana = 0;
            }
            $this->comment = "$this->name a recup $healthGain points de vie contre $usedMana points de mana";
            return $this;
        } else {
            $this->comment = "$this->name n'a plus assez de mana pour se soigner";
            return false;
        }
    }
}
