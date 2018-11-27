<?php

class BDD
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $port = DB_PORT;
    
    private $dbh;
    private $error;

    private $stmt;

    public function __construct()
    {
        $dsn = 'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname.';charset=utf8';
        //$dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname.';charset=utf8';
        $options =
            [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_AUTOCOMMIT => false,
            ];

      try
      {
        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
      } catch (PDOException $e)
        {
          $this->error = $e->getMessage();
          echo $this->error;
        }
    }

    /* *
     * @query: sql query
     *
     * La méthode Query introduit la fonction PDO::prepare
     */
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
        return $this->stmt;
    }


    /**
     * @param $param
     * @param $value
     * @param null $type
     * @value: valeur à insérer
     *
     * Pour préparer les requêtes SQL, tu as besoin d'assigner(bind)
     * tes valeurs avec leur placeholder (nom dans la bdd).
     * Cette méthode bind est basé sur la méthode
     * PDOStatement::bindValue.
     */

    public function bind($param, $value, $type = null)
    {
        if (is_null($type))
        {
            switch (true)
            {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
     $this->stmt->bindValue($param, $value, $type);
    }


    /**
     * La méthode qui suit est basée sur PDOStatement::execute.
     *  Sert à executer la/les requête préparée .
     **/
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * @return mixed
     * La fonction resultSet retourne an array of the result set rows.
     * Elle utilise la méthode PDOStatement::fetchAll.
     * On lance la méthode execute, puis on retourne LES resultat.
     */
    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     * Encore une fois, on lance la méthode execute,
     * et on retourne LE resultat.
     * Méthode : PDOStatement::fetch.
     */
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     *  Method :  PDOStatement::rowCount.
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * @return string
     * Retourne le dernier ID insérer dans la bdd sous forme de String.
     * Method : PDO::lastInsertId.
     */
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    /**
     *  The accessing user would see incorrect data
     * (a user without configuration) which could potentially expose our
     * system to errors.
     */

    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->dbh->commit();
    }

    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }

    /**
     * Dumps les informations de la requête préparée
     * Méthode :  PDOStatement::debugDumpParams.
     */

    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }
}


