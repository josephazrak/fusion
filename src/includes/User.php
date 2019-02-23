<?php

class FusionUser 
{
    private $database;

    public function __construct($db) 
    {
        $this -> database = $db;
        if (!$db->connected)
            $db->connect();
    }

    /**
     * Checks if the user exists in the database
     * @return bool
     */
    public function doesLoginWork($username, $password)
    {
        $stmt = $this->database->instance()->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $res = $stmt->fetch();

        if ($res === false)
            return false;
        
        $salt = $res["salt"];
        $pass = $res["password"];

        $hash = hash("sha512", $password . "#" . $salt);

        if ($hash == $pass) 
            return true;
        
        return false;
    }
}