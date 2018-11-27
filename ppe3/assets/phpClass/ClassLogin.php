<?php
class Login
{
    private $login;
    private $password;
    private $matriculeVisiteur;

    private $error;

    public function __construct($login)
    {
        try {
            $database = new BDD();
            $database->query('select VIS_NOM, VIS_MDP, VIS_MATRICULE from visiteur where VIS_NOM = :login');
            $database->bind(':login', $login);

            $row = $database->single();

            $this->matriculeVisiteur = $row['VIS_MATRICULE'];
            $this->login = $row['VIS_NOM'];
            $this->password = $row['VIS_MDP'];

        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo '<pre>' . $this->error . '</pre>';
        }
    }


    public function connexion($passwordPost, $loginPost)
    {
        if ($loginPost === $this->login) {
            session_start();
            $_SESSION['id'] = $this->matriculeVisiteur;
            return true;
        }
        return false;
    }
    
}