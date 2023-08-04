<?php
class Fight
{
    // public string $name;
    // public float $power;
    // public float $mana;
    // public float $health;
    // public string $comment;
    public object $player1;
    public object $player2;

    public function __construct($player1, $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }
}
