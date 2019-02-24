<?php
    class Navbar 
    {
        private $raw_html = "";
        private $auth_provider;

        public function setNavbarType( String $type )
        {
            switch ($type) 
            {
                case "loggedOut":
                    $this -> raw_html = file_get_contents(__DIR__ . "/navbar_loggedout.html");
                    break;
                case "loggedIn":
                    $this -> raw_html = sprintf(file_get_contents(__DIR__ . "/navbar_loggedin.html"), ($this -> auth_provider)::getLoggedInNiceName());
                default:
                    break;
            }
        }

        public function render() 
        {
            echo($this -> raw_html);
        }

        public function setAuthProvider($provider)
        {
            $this->auth_provider = $provider;
        }
    }
?>