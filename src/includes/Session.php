<?php

    class FusionSessionInterface {
        public static function isLoggedIn()
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            return (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) ? true : false;
        }

        public static function setIsLoggedIn($value)
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION["loggedIn"] = $value;
        }

        public static function setLoggedInUser($username, $niceName)
        {
            self::setIsLoggedIn(true);

            $_SESSION["auth"] = [
                "authenticatedAs" => $username,
                "niceName" => $niceName
            ];
        }

        public static function destroySession()
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            session_destroy();
        }

        public static function getLoggedInUsername()
        {
            return (self::isLoggedIn() ? $_SESSION["auth"]["authenticatedAs"] : "<ERR:NLI!!>");
        }

        public static function getLoggedInNiceName() {
            return (self::isLoggedIn() ? $_SESSION["auth"]["niceName"] : "<ERR:NLI!!>");
        }
    }