<?php
    class Logger {
        private $db;

        public function addLogEntry($type, $severity, $message)
        {
            $stmt = $this -> db -> instance() -> prepare("INSERT INTO `logs` (`type`, `severity`, `message`, `datetime`) VALUES (:type, :severity, :message, now())");

            $stmt -> bindParam("type", $type);
            $stmt -> bindParam("severity", $severity);
            $stmt -> bindParam("message", $message);

            return ($stmt -> execute());
        }

        public function getAllLogs()
        {
            $stmt = $this -> db -> instance() -> prepare("SELECT * FROM `logs`");
            $stmt -> execute();
            $res = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            return $res;
        }

        public function __construct($database)
        {
            $this -> db = $database;
        }
    }
?>