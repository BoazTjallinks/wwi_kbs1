<?php

class cat {
    protected $options = [
        "limit",
        "colorid",
        "minprice",
        "maxprice",
        "size"
    ];
    
    protected $defaultvalue = [
        25,
        0,
        0,
        0,
        "na"
    ];

    public function checkGetParams() {
        if (!isset($_GET['catid']) || !isset($_GET['page'])){
            header('location: /home');
        }
    }
    
    public function checkFilterSession() {    
        for ($i=0; $i < count($this->options); $i++) {
            if (!isset($_SESSION[$this->options[$i]])) {
                $_SESSION[$this->options[$i]] = $this->defaultvalue[$i];
            }
        }
    }
    
    public function clearSession($param) {
        for ($i=0; $i < count($this->options); $i++) {
            if ($param == $this->options[$i]) {
                $_SESSION[$this->options[$i]] = $this->defaultvalue[$i];
            }
        }
    }

    public function getOptions() {
        return $this->options;
    }

    public function getDefaultnr($param) {
        for ($i=0; $i < count($this->options); $i++) {
            if ($param == $this->options[$i]) {
                return $this->defaultvalue[$i];
            }
        }
    }
}