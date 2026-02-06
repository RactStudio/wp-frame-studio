<?php

namespace RactStudio\FrameStudio\Http;

class Response
{
    protected $content;
    protected $status;
    protected $headers;

    public function __construct($content = '', $status = 200, array $headers = [])
    {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
    }

    public function send()
    {
        if (!headers_sent()) {
            http_response_code($this->status);
            foreach ($this->headers as $key => $value) {
                header("$key: $value");
            }
        }

        echo $this->content;
        
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif (!in_array(PHP_SAPI, ['cli', 'phpdbg'])) {
             // Basic close
        }
    }
    
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
