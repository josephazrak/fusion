<?php

    /**
     * Materialize footer.html
     *
     */

    $INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
    require_once($INCLUDE_ROOT . "EnvDetect.php");

    class UIFooter {
        public static function render() {
            echo sprintf(file_get_contents(__DIR__ . "/footer/footer.html"), (Env::Get() == "dev"? "local development server" : "remote production server"));
        }
    }
