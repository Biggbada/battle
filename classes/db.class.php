<?php

class SPDO
{
    /**
     * Instance de la classe PDO
     *
     * @var PDO
     * @access private
     */
    static ?PDO $PDOInstance = null;

    /**
     * Constante: nom d'utilisateur de la bdd
     *
     * @var string
     */
    const DEFAULT_SQL_USER = 'root';

    /**
     * Constante: hôte de la bdd
     *
     * @var string
     */
    const DEFAULT_SQL_HOST = 'localhost';

    /**
     * Constante: hôte de la bdd
     *
     * @var string
     */
    const DEFAULT_SQL_PASS = '';

    /**
     * Constante: nom de la bdd
     *
     * @var string
     */
    const DEFAULT_SQL_DTB = 'battlev2';

    /**
     * Crée et retourne l'objet SPDO
     *
     * @access public
     * @static
     * @param void
     * @return PDO $instance
     */
    public static function getInstance(): PDO
    {
        if (is_null(self::$PDOInstance)) {
            self::$PDOInstance = new PDO('mysql:dbname=' . self::DEFAULT_SQL_DTB . ';host=' . self::DEFAULT_SQL_HOST, self::DEFAULT_SQL_USER, self::DEFAULT_SQL_PASS);
        }
        return self::$PDOInstance;
    }
    static function updateDB($db, $playerOne, $playerTwo)
    {
        $dbUpdatePlayer = $db->prepare("UPDATE players SET mana = :mana, health = :health, comment = :comment WHERE playerName = :playerName");
        $dbUpdatePlayer->bindParam(':playerName', $playerOne->name);
        $dbUpdatePlayer->bindParam(':mana', $playerOne->mana);
        $dbUpdatePlayer->bindParam(':health', $playerOne->health);
        $dbUpdatePlayer->bindParam(':comment', $playerOne->comment);
        $dbUpdatePlayer->execute();
        $dbUpdateAdversaire = $db->prepare("UPDATE players SET mana = :mana, health = :health, comment = :comment  WHERE playerName = :playerName");
        $dbUpdateAdversaire->bindParam(':playerName', $playerTwo->name);
        $dbUpdateAdversaire->bindParam(':mana', $playerTwo->mana);
        $dbUpdateAdversaire->bindParam(':health', $playerTwo->health);
        $dbUpdateAdversaire->bindParam(':comment', $playerTwo->comment);
        $dbUpdateAdversaire->execute();
    }

    public static function getPlayers($db)
    {
        $db = SPDO::getInstance();
        $selectDatas = $db->query('SELECT * FROM players');
        $datas = $selectDatas->fetchAll();
        foreach ($datas as $key => $player) {
            return $player;
        }
    }
    public static function findPlayer($dbPLayers, $playerName)
    {
        foreach ($dbPLayers as $player) {
            dump($player);
            if ($player['name'] === $playerName) {
                echo ($player['name'] . ' ' . $player['id']);
                return $player['id'];
            }
        }
    }
}
