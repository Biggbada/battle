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
            self::$PDOInstance =
                new PDO('mysql:dbname=' . self::DEFAULT_SQL_DTB . ';host=' . self::DEFAULT_SQL_HOST, self::DEFAULT_SQL_USER, self::DEFAULT_SQL_PASS);
        }
        self::$PDOInstance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return self::$PDOInstance;
    }


    public static function getPlayers()
    {
        $db = SPDO::getInstance();
        return $db->query('SELECT * FROM players')->fetchAll();
    }

    public static function setPlayer($name, $mana, $health, $power): int
    {
        $db = SPDO::getInstance();
        $insert = $db->prepare('INSERT INTO players(`name`, initial_mana, initial_health, initial_pow) VALUES(:playerName, :mana, :health, :power)');
        $insert->bindParam(':playerName', $name);
        $insert->bindParam(':mana', $mana);
        $insert->bindParam(':health', $health);
        $insert->bindParam(':power', $power);
        $insert->execute();
        return $db->lastInsertId();
    }

    public static function setFight(Player $player, Player $adversaire): int
    {
        $db = SPDO::getInstance();
        $insert = $db->prepare('INSERT INTO fights(id_p1, id_p2) VALUES(:id_p1, :id_p2)');
        $insert->execute(["id_p1" => $player->id, "id_p2" => $adversaire->id]);
        return $db->lastInsertId();
    }


    public static function setWinner($winnerID, $battleLog, $fightID)
    {
        $db = SPDO::getInstance();
        $insertWinner = $db->prepare("UPDATE fights SET id_victory=:id_victory, battle_log=:battle_log WHERE id=:id");
        $insertWinner->execute([":id_victory" => $winnerID, ":battle_log" => $battleLog, ":id" => intval($fightID)]);
    }

    public static function getFights(): array
    {
        $db = self::getInstance();
        $fightsHistory = $db->prepare('SELECT * FROM fights');
        $fightsHistory->execute();
        return $fightsHistory->fetchAll();
    }

    public static function getPlayer($id): Player
    {
        $db = self::getInstance();
        $fightsHistory = $db->prepare('SELECT * FROM players where id = :id');
        $fightsHistory->execute(["id" => $id]);
        $fightsHistory->setFetchMode(PDO::FETCH_CLASS, 'Player');
        return $fightsHistory->fetch();
    }

    public static function getPlayerByName($name): bool|Player
    {
        $db = self::getInstance();
        $fightsHistory = $db->prepare('SELECT * FROM players where name = :name');
        $fightsHistory->execute(["name" => $name]);
        $fightsHistory->setFetchMode(PDO::FETCH_CLASS, 'Player');
        return $fightsHistory->fetch();
    }
    public static function getBestPlayer()
    {
        $db = self::getInstance();
        $bestPlayers = $db->prepare('SELECT id_victory, COUNT(id_victory)FROM fights GROUP BY id_victory ORDER BY COUNT(*) DESC');
        dump($bestPlayers);
        $bestPlayers->execute();
        dump($bestPlayers);
        $bestPlayers->setFetchMode(PDO::FETCH_CLASS, 'Player');
        dump($bestPlayers);
        // $bestPlayers->setFetchMode(PDO::FETCH_CLASS, 'Player');
        return $bestPlayers->fetch();
    }
}
