<?php

namespace fr\dieunelson\webservices\hello;

class Hello{

    private $title;
    private $message;
    private $website;

    public function __construct()
    {
        $this->title = "Hello Page";
        $this->message = "ExpressPHP by Shortlink";
        $this->website = "https://dieunelson.fr";
    }

    public function data()
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'website' => $this->website
        ];
    }
}