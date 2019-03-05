<?php
    class Navbar 
    {
        private $raw_html = "";
        private $auth_provider;
        private $render_framework = "bootstrap";

        public function setNavbarType( $type )
        {
            switch ($type) 
            {
                case "loggedOut":
                    $this -> raw_html = file_get_contents(__DIR__ . "/navbar/".$this -> render_framework."/navbar_loggedout.html");
                    break;
                case "loggedIn":
                    $this -> raw_html = sprintf(file_get_contents(__DIR__ . "/navbar/" .$this -> render_framework. "/navbar_loggedin.html"), ($this -> auth_provider)::getLoggedInNiceName());
                default:
                    break;
            }
        }

        public function setNavbarFramework( $framework )
        {
            $this->render_framework = $framework;
        }

        public function bindParam($param, $val)
        {
            $this->raw_html = str_replace($param, $val, $this->raw_html);
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