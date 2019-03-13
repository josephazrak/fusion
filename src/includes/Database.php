<?php
    $INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
    require_once($INCLUDE_ROOT . "EnvDetect.php");

    class FusionDBInterface
    {
        private $host = "127.0.0.1";
        private $db = "fusion";
        private $port = "3306";
        private $user = "pangaea-db";
        private $pass = "pangaea1213";

        private $inst;

        public $connected = false;

        public function connect()
        {
            if (Env::Get() == "dev")
                $this->port = "3307";

            try {
                $conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db, $this->user, $this->pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $this->inst = $conn;
                $this->connected = true;
            } catch (PDOException $e) {
                echo "DB CONNECT FAIL! " . $e->getMessage();
            }
        }

        public function instance()
        {
            return $this->inst;
        }
    }