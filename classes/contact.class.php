<?php
class Contact
{
    public string $nom;
    public string $prenom;
    public string $email;
    public string $message;
    public function __construct($nom, $prenom, $email, $message)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->message = $message;
    }
}


use SPDO as GlobalSPDO;

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
    const DEFAULT_SQL_DTB = 'contactform';

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


    public static function setContact($nom, $prenom, $email, $message)
    {
        $db = GlobalSPDO::getInstance();
        $insertContact = $db->prepare('INSERT INTO contact(`nom`, prenom, email, message) VALUES(:nom, :prenom, :email, :message)');
        $insertContact->execute([':nom' => $nom, ':prenom' => $prenom, ':email' => $email, ':message' => $message]);
        return $db->lastInsertId();
    }
}
