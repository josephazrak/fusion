<?php
    class FusionDB {
        private $host = "127.0.0.1";
        private $port = "3306";
        private $db   = "fusion";

        private $user = "root";
        private $pass = "pangaea1213";

        private $inst;

        public function connect() 
        {
            try
            {
                $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            catch (PDOException $e) 
            {
                echo "DB CONNECT FAIL! " . $e->getMessage();
            }
        }
    }