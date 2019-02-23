<?php
    class Navbar 
    {
        private $raw_html = "";

        public function setNavbarType( String $type )
        {
            switch ($type) 
            {
                case "loggedOut":
                    $this -> raw_html = file_get_contents(__DIR__ . "/navbar_loggedout.html");
                    break;
                default:
                    break;
            }
        }

        public function render() 
        {
            echo($this -> raw_html);
        }
    }
?>