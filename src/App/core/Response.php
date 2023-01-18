<?php

class Response
{
    protected $statusCode;
    protected $statusText;

    public function send()
    {
        header('HTTP/1.1 ' . $this->statusCode . ' ' . $this->statusText);
    }

    public function setStatusCode($statusCode, $statusText)
    {
        $this->statusCode = $statusCode;
        $this->statusText = $statusText;
    }
}
