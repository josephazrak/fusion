<?php
    class FusionDBInterface {
        private $host = "127.0.0.1";
        private $db   = "fusion";
        private $port = "3307";
        private $user = "root";
        private $pass = "pangaea1213";

        private $inst;

        public $connected = false;

        public function connect()
        {
            try
            {
                $conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db, $this->user, $this->pass);
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $this -> inst = $conn;
                $this -> connected = true;
            } 
            catch (PDOException $e) 
            {
                echo "DB CONNECT FAIL! " . $e->getMessage();
            }
        }

        public function instance() 
        {
            return $this -> inst;
        }
    }