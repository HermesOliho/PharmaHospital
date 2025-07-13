<?php

namespace HeromTech;

class Request
{
    public string $url;

    public string $controller;
    public string $action;
    public array $params;
    public $body = null;

    public function __construct()
    {
        $this->url = $_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'];
        $this->body = array_merge(json_decode(file_get_contents("php://input"), true) ?? [], $_POST);
        $this->cleanBody();
    }

    protected function cleanBody()
    {
        $inputs = $this->body;
        foreach ($inputs as $key => $value) {
            if (is_string($value)) {
                $value = trim(htmlspecialchars($value));
                if ($key === "email") {
                    $value = strtolower($value);
                }
            }
            $this->body[$key] = $value;
        }
    }
}
