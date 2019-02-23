<?php

class APIRequest {
    private $status = [
        "success" => true,
        "message" => ""
    ];

    public function fail($message = "") 
    {
        if (!empty($message)) 
        {
            $this -> status["message"] = $message;
        }

        $this -> status["success"] = false;
        return $this;
    }

    public function terminate($message = "")
    {
        if (!empty($message)) 
        {
            $this -> status["message"] = $message;
        }

        die(json_encode($this -> status));
    }

    public function message($message)
    {
        $this -> status["message"] = $message;
        return $this;
    }
}