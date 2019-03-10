<?php
    class Env {
        public static function Get() {
            if (substr($_SERVER["HTTP_HOST"], 0, 10) == "localhost" || substr($_SERVER["HTTP_HOST"], 0, 3) == "10." || substr($_SERVER["HTTP_HOST"], 0, 7) == "192.168") {
                return "dev";
            } else {
                return "prod";
            }
        }
    }